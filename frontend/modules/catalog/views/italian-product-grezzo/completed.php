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
//
use thread\widgets\grid\{
    GridViewFilter
};

/**
 * @var $pages Pagination
 * @var $model ItalianProduct
 * @var $filter ItalianProduct
 */

$dataProvider = $model->completed(Yii::$app->request->queryParams);
$dataProvider->sort = false;

$this->title = Yii::t('app', 'Завершенные') . '. ' . $this->context->title;;

?>

<main>
    <div class="page category-page">
        <div class="largex-container itprod-box">
            <div class="row title-cont">

                <?= Html::tag('h1', $this->title); ?>
                <div class="itprod-panel-add">
                    <?= Html::a(
                        '<i class="fa fa-list"></i> ' . Yii::t('app', 'Активные'),
                        Url::toRoute(['/catalog/italian-product-grezzo/list']),
                        ['class' => 'btn']
                    ) ?>

                    <?= Html::a(
                        '<i class="fa fa-list"></i> ' . Yii::t('app', 'Завершенные'),
                        null,
                        ['class' => 'btn']
                    ) ?>
                </div>

                <?= Breadcrumbs::widget([
                    'links' => $this->context->breadcrumbs,
                ]) ?>

            </div>
            <div class="cat-content">
                <div class="row">

                    <div class="col-md-12 col-lg-12">
                        <div class="cont-area cont-goods">

                            <?php Pjax::begin(['id' => 'factory-product']); ?>

                            <?= GridView::widget([
                                'id' => 'italian-product-grid',
                                'dataProvider' => $dataProvider,
                                //'filterModel' => $filter,
                                'filterUrl' => Url::toRoute(['/catalog/italian-product-grezzo/list']),
                                'panel' => [
                                    'after' => false,
                                    'before' => false,
                                    'heading' => false
                                ],
                                'columns' => [
                                    [
                                        'format' => 'raw',
                                        'attribute' => 'image_link',
                                        'value' => function ($model) {
                                            /** @var $model ItalianProduct */
                                            return
                                                Html::a(
                                                    Html::img(
                                                        ItalianProduct::getImageThumb($model['image_link']),
                                                        ['width' => 200]
                                                    ),
                                                    Url::toRoute(
                                                        ['/catalog/italian-product-grezzo/update', 'id' => $model->id]
                                                    )
                                                );
                                        },
                                        'headerOptions' => ['class' => 'col-sm-1'],
                                        'contentOptions' => ['class' => 'text-center'],
                                        'filter' => false
                                    ],
                                    [
                                        'format' => 'raw',
                                        'attribute' => 'title',
                                        'value' => function ($model) {
                                            /** @var $model ItalianProduct */
                                            return $model['lang']['title'];
                                        },
                                        'label' => Yii::t('app', 'Title'),
                                    ],
                                    [
                                        'attribute' => 'factory_id',
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            /** @var $model ItalianProduct */
                                            return ($model['factory'])
                                                ? $model['factory']['title']
                                                : $model['factory_name'];
                                        },
                                        'filter' => false,
                                        'headerOptions' => ['class' => 'col-sm-2'],
                                    ],
                                    [
                                        'attribute' => 'price_new',
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            /** @var $model ItalianProduct */
                                            return $model['price_new'] . ' ' . $model['currency'];
                                        },
                                        'filter' => false,
                                        'headerOptions' => ['class' => 'col-sm-2'],
                                    ],
                                    [
                                        'label' => Yii::t('app', 'Количество просмотров'),
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            /** @var $model ItalianProduct */
                                            return $model->getCountViews();
                                        },
                                    ],
                                    [
                                        'label' => Yii::t('app', 'Количество запросов'),
                                        'value' => function ($model) {
                                            /** @var $model ItalianProduct */
                                            return $model->getCountRequests();
                                        },
                                    ],
                                    [
                                        'format' => 'raw',
                                        'attribute' => Yii::t('app', 'Status'),
                                        'value' => function ($model) {
                                            /** @var $model ItalianProduct */

                                            if ($model->published == 1) {
                                                $status = $model->getDiffPublishedDate();
                                            } else {
                                                $status = Html::a(
                                                    Yii::t('app', 'Опубликовать'),
                                                    ['/catalog/italian-product-grezzo/payment'],
                                                    [
                                                        'data-method' => 'POST',
                                                        'data-params' => [
                                                            '_csrf' => Yii::$app->getRequest()->getCsrfToken(),
                                                            'id[]' => $model->id,
                                                        ],
                                                    ]
                                                );
                                            }

                                            if ($model->payment && $model->payment->payment_status == 'success') {
                                                $status = Yii::t('app', 'На модерации');
                                            }

                                            return $status;
                                        },
                                        'headerOptions' => ['class' => 'col-sm-2'],
                                        'contentOptions' => ['class' => 'text-center'],
                                    ],
                                ],
                            ]); ?>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</main>
