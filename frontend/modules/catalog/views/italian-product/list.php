<?php

use yii\helpers\{
    Html, Url
};
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
 * @var \yii\data\Pagination $pages
 * @var $model \frontend\modules\catalog\models\ItalianProduct
 */

$dataProvider = $model->search(Yii::$app->request->queryParams);
$dataProvider->sort = false;

$this->title = Yii::t('app', 'Furniture in Italy');

?>

<main>
    <div class="page category-page">
        <div class="container large-container">
            <div class="row title-cont">

                <?= Html::tag('h1', Yii::t('app', 'Furniture in Italy')); ?>

                <?= Html::a(
                    '<i class="fa fa-plus"></i> ' . Yii::t('app', 'Add'),
                    Url::toRoute(['/catalog/italian-product/create']),
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
                                'filterUrl' => Url::toRoute(['/catalog/italian-product/list']),
                                'columns' => [
                                    [
                                        'format' => 'raw',
                                        'attribute' => 'image_link',
                                        'value' => function ($model) {
                                            /** @var \frontend\modules\catalog\models\ItalianProduct $model */
                                            return Html::img(ItalianProduct::getImageThumb($model['image_link']), ['width' => 50]);
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
                                            /** @var $model \frontend\modules\catalog\models\ItalianProduct */
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
                                        'class' => yii\grid\ActionColumn::class,
                                        'template' => '{update} {delete}',
                                        'buttons' => [
                                            'update' => function ($url, $model) {
                                                /** @var $model \frontend\modules\catalog\models\ItalianProduct */
                                                return Html::a(
                                                    '<span class="glyphicon glyphicon-pencil"></span>',
                                                    Url::toRoute(['/catalog/italian-product/update', 'id' => $model->id]),
                                                    [
                                                        'class' => 'btn btn-default btn-xs'
                                                    ]
                                                );
                                            },
                                            'delete' => function ($url, $model) {
                                                /** @var $model \frontend\modules\catalog\models\ItalianProduct */
                                                return Html::a(
                                                    '<span class="glyphicon glyphicon-trash"></span>',
                                                    Url::toRoute(['/catalog/italian-product/intrash', 'id' => $model->id]),
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
