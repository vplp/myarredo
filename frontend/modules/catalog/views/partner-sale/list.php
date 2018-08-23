<?php

use yii\helpers\{
    Html, Url
};
use yii\widgets\Pjax;
use kartik\grid\GridView;
//
use frontend\components\Breadcrumbs;
use frontend\modules\catalog\models\{
    Sale, Factory
};
//
use thread\widgets\grid\{
    GridViewFilter
};

/**
 * @var \yii\data\Pagination $pages
 * @var $model \frontend\modules\catalog\models\Sale
 */

$dataProvider = $model->search(Yii::$app->request->queryParams);
$dataProvider->sort = false;

$this->title = $this->context->title;

?>

<main>
    <div class="page category-page">
        <div class="container large-container">
            <div class="row title-cont">

                <?= Html::tag('h1', $this->context->title); ?>

                <?= Html::a(
                    '<i class="fa fa-plus"></i> ' . Yii::t('app', 'Add'),
                    Url::toRoute(['/partner/sale/create']),
                    ['class' => 'btn btn-goods']
                ) ?>

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
                                'dataProvider' => $dataProvider,
                                'filterModel' => $filter,
                                'filterUrl' => Url::toRoute(['/catalog/partner-sale/list']),
                                'columns' => [
                                    [
                                        'format' => 'raw',
                                        'attribute' => 'image_link',
                                        'value' => function ($model) {
                                            /** @var \frontend\modules\catalog\models\Sale $model */
                                            return Html::img(Sale::getImageThumb($model['image_link']), ['width' => 50]);
                                        },
                                        'headerOptions' => ['class' => 'col-sm-1'],
                                        'contentOptions' => ['class' => 'text-center'],
                                        'filter' => false
                                    ],
                                    [
                                        'attribute' => 'title',
                                        'value' => 'lang.title',
                                        'label' => Yii::t('app', 'Title'),
                                    ],
                                    [
                                        'attribute' => 'factory_id',
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            /** @var $model \frontend\modules\catalog\models\Sale */
                                            return ($model['factory']) ? $model['factory']['title'] : $model['factory_name'];
                                        },
                                        'filter' => GridViewFilter::selectOne(
                                            $filter,
                                            'factory_id',
                                            Factory::dropDownList()
                                        ),
                                    ],
                                    [
                                        'format' => 'raw',
                                        'attribute' => 'published',
                                        'value' => function ($model) {
                                            /** @var $model \frontend\modules\catalog\models\FactoryProduct */
                                            return Html::checkbox(false, $model->published, ['disabled' => true]);
                                        },
                                        'headerOptions' => ['class' => 'col-sm-1'],
                                        'contentOptions' => ['class' => 'text-center'],
                                        'filter' => GridViewFilter::selectOne(
                                            $filter,
                                            'published',
                                            [
                                                0 => 'On',
                                                1 => 'Off'
                                            ]
                                        ),
                                    ],
                                    [
                                        'label' => 'Просмотры товара',
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            /** @var $model \frontend\modules\catalog\models\Sale */
                                            return $model->getCountViews();
                                        },
                                    ],
                                    [
                                        'label' => 'Запрос телефона',
                                        'value' => function ($model) {
                                            /** @var $model \frontend\modules\catalog\models\Sale */
                                            return $model->getCountRequestPhone();
                                        },
                                    ],
                                    [
                                        'class' => yii\grid\ActionColumn::class,
                                        'template' => '{update} {delete}',
                                        'buttons' => [
                                            'update' => function ($url, $model) {
                                                /** @var $model \frontend\modules\catalog\models\Sale */
                                                return Html::a(
                                                    '<span class="glyphicon glyphicon-pencil"></span>',
                                                    Url::toRoute(['/catalog/partner-sale/update', 'id' => $model->id]),
                                                    [
                                                        'class' => 'btn btn-default btn-xs'
                                                    ]
                                                );
                                            },
                                            'delete' => function ($url, $model) {
                                                /** @var $model \frontend\modules\catalog\models\Sale */
                                                return Html::a(
                                                    '<span class="glyphicon glyphicon-trash"></span>',
                                                    Url::toRoute(['/catalog/partner-sale/intrash', 'id' => $model->id]),
                                                    [
                                                        'class' => 'btn btn-default btn-xs',
                                                        'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                                    ]
                                                );
                                            },
                                        ],
                                        'buttonOptions' => ['class' => 'btn btn-default btn-xs'],
                                        'headerOptions' => ['class' => 'col-sm-1',],
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
