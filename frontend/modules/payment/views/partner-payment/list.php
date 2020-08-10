<?php

use yii\helpers\{
    Html, Url
};
use yii\data\Pagination;
use yii\web\View;
use yii\widgets\Pjax;
use kartik\grid\GridView;
//
use frontend\components\Breadcrumbs;
use frontend\modules\catalog\models\ItalianProduct;
use frontend\modules\payment\models\{
    Payment
};

/**
 * @var $pages Pagination
 * @var $model Payment
 * @var $filter Payment
 */

$this->title = Yii::t('app', 'Платежная информация');

?>

<main>
    <div class="page category-page">
        <div class="largex-container itprod-box">
            <div class="row title-cont">

                <?= Html::tag('h1', Yii::t('app', 'Платежная информация')); ?>

                <?= Breadcrumbs::widget([
                    'links' => $this->context->breadcrumbs,
                ]) ?>

            </div>
            <div class="cat-content">
                <div class="row">

                    <div class="col-md-12 col-lg-12">
                        <div class="cont-area cont-goods">

                            <?php Pjax::begin(['id' => 'partner-payment']); ?>

                            <?= GridView::widget([
                                'id' => 'partner-payment-grid',
                                'dataProvider' => $dataProvider,
                                'filterUrl' => Url::toRoute(['/payment/partner-payment/list']),
                                'panel' => [
                                    'after' => false,
                                    'before' => false,
                                    'heading' => false,
                                    'footer' => false
                                ],
                                'columns' => [
                                    [
                                        'attribute' => 'type',
                                        'value' => function ($model) {
                                            /** @var $model Payment */
                                            return $model->getInvDesc();
                                        },
                                        'filter' => false,
                                    ],
                                    [
                                        'label' => Yii::t('app', 'Title'),
                                        'value' => function ($model) {
                                            /** @var $model Payment */
                                            $arr = [];
                                            if ($model->type == 'italian_item') {
                                                foreach ($model->items as $item) {
                                                    /** @var $item ItalianProduct */
                                                    $arr[] = $item->getTitle();
                                                }
                                            }
                                            return implode(', ', $arr);
                                        },
                                        'headerOptions' => ['class' => 'text-center'],
                                        'contentOptions' => ['class' => 'text-center'],
                                        'visible' => false
                                    ],
                                    [
                                        'label' => Yii::t('app', 'Image'),
                                        'format' => 'raw',
                                        //'attribute' => 'image_link',
                                        'value' => function ($model) {
                                            /** @var $model Payment */
                                            $arr = [];
                                            if ($model->type == 'italian_item') {
                                                foreach ($model->items as $item) {
                                                    /** @var $item ItalianProduct */
                                                    $arr[] = Html::a(
                                                        Html::img(
                                                            ItalianProduct::getImageThumb($item['image_link']),
                                                            ['width' => 200]
                                                        ),
                                                        Url::toRoute(
                                                            ['/catalog/italian-product/update', 'id' => $item->id]
                                                        )
                                                    );
                                                }
                                            }
                                            return implode(', ', $arr);
                                        },
                                        'headerOptions' => ['class' => 'col-sm-1'],
                                        'contentOptions' => ['class' => 'text-center'],
                                        'visible' => false
                                    ],
                                    [
                                        'attribute' => 'created_at',
                                        'value' => function ($model) {
                                            /** @var $model Payment */
                                            return date('d.m.Y H:i', $model['created_at']);
                                        },
                                        'headerOptions' => ['class' => 'text-center'],
                                        'contentOptions' => ['class' => 'text-center'],
                                        'visible' => false
                                    ],
                                    [
                                        'attribute' => 'payment_status',
                                        'value' => function ($model) {
                                            /** @var $model Payment */
                                            return $model::paymentStatusRange($model['payment_status']);
                                        },
                                        'headerOptions' => ['class' => 'text-center'],
                                        'contentOptions' => ['class' => 'text-center'],
                                    ],
                                    [
                                        'attribute' => 'payment_time',
                                        'value' => function ($model) {
                                            /** @var $model Payment */
                                            return $model['payment_status'] == 'success'
                                                ? date('d.m.Y H:i', $model['payment_time'])
                                                : '';
                                        },
                                        'headerOptions' => ['class' => 'text-center'],
                                        'contentOptions' => ['class' => 'text-center'],
                                    ],
                                    [
                                        'format' => 'raw',
                                        'attribute' => 'amount',
                                        'value' => function ($model) {
                                            /** @var $model Payment */
                                            return $model->amount . ' ' . $model->currency;
                                        },
                                        'headerOptions' => ['class' => 'col-sm-1'],
                                        'contentOptions' => ['class' => 'text-center'],
                                    ],
                                ],
                            ]) ?>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</main>
