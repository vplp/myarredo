<?php

use yii\helpers\{
    Html, Url
};
use yii\data\Pagination;
use yii\widgets\Pjax;
use kartik\grid\GridView;
//
use frontend\components\Breadcrumbs;
use frontend\modules\catalog\models\{
    ItalianProduct, Factory
};

/**
 * @var $pages Pagination
 * @var $model ItalianProduct
 * @var $filter ItalianProduct
 */

$this->title = $this->context->title;

?>

<main>
    <div class="page category-page">
        <div class="largex-container itprod-box">
            <div class="row title-cont">
                <?= Breadcrumbs::widget([
                    'links' => $this->context->breadcrumbs,
                ]) ?>
            </div>
            <div class="cat-content">
                <div class="row">
                    <div class="col-md-12 col-lg-12">
                        <div class="cont-area cont-goods">

                            <?= GridView::widget([
                                'id' => 'italian-product-grid',
                                'dataProvider' => $dataProvider,
                                'columns' => [
                                    [
                                        'format' => 'raw',
                                        'label' => Yii::t('app', 'Image link'),
                                        'value' => function ($model) {
                                            /** @var $model ItalianProduct */
                                            return Html::img(
                                                ItalianProduct::getImageThumb($model['product']['image_link']),
                                                ['width' => 50]
                                            );
                                        },
                                        'headerOptions' => ['class' => 'col-sm-2'],
                                        'contentOptions' => ['class' => 'text-center'],
                                        'filter' => false
                                    ],
                                    [
                                        'format' => 'raw',
                                        'label' => Yii::t('app', 'Title'),
                                        'value' => function ($model) {
                                            /** @var $model ItalianProduct */
                                            return Html::a(
                                                $model['product']['title'],
                                                ItalianProduct::getUrl($model['product']['alias']),
                                                ['target' => '_blank']
                                            );
                                        },
                                        'headerOptions' => ['class' => 'col-sm-2'],
                                        'contentOptions' => ['class' => 'text-center'],
                                        'filter' => false
                                    ],
                                    [
                                        'format' => 'raw',
                                        'label' => Yii::t('app', 'Answer time'),
                                        'value' => function ($model) {
                                            /** @var $model ItalianProduct */
                                            return date('d-m-Y', $model['order']['orderAnswer']['answer_time']);
                                        },
                                        'headerOptions' => ['class' => 'col-sm-2'],
                                        'contentOptions' => ['class' => 'text-center'],
                                        'filter' => false
                                    ],
                                    [
                                        'format' => 'raw',
                                        'label' => 'стоимость доставки',
                                        'value' => function ($model) {
                                            /** @var $model ItalianProduct */
                                            return $model['orderItemPrice']['price'];
                                        },
                                    ],
                                    [
                                        'format' => 'raw',
                                        'label' => 'к оплате',
                                        'value' => function ($model) {
                                            /** @var $model ItalianProduct */
                                            return $model->getDeliveryAmount();
                                        },
                                    ],
                                    [
                                        'format' => 'raw',
                                        'label' => 'оплатить',
                                        'value' => function ($model) {
                                            /** @var $model ItalianProduct */
                                            return Html::a(
                                                Yii::t('app', 'Оплатить'),
                                                Url::toRoute([
                                                    '/shop/partner-order/pay-italy-delivery',
                                                    'id' => $model['id']
                                                ], true),
                                                ['class' => 'btn btn-goods']
                                            );
                                        },
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
