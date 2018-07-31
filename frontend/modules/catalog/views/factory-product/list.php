<?php

use yii\helpers\{
    Html, Url
};
use yii\widgets\Pjax;
use yii\grid\GridView;
use frontend\components\Breadcrumbs;
//
use frontend\modules\catalog\models\{
    Category, Factory, Product
};
//
use thread\widgets\grid\{
    ActionStatusColumn, GridViewFilter
};

/**
 * @var \yii\data\Pagination $pages
 * @var $model \frontend\modules\catalog\models\FactoryProduct
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
                    Url::toRoute(['/catalog/factory-product/create']),
                    ['class' => 'btn btn-goods']
                ) ?>

                <?= Html::a(
                    Yii::t('app', 'Рекламные компании'),
                    Url::toRoute(['/catalog/factory-promotion/list']),
                    ['class' => 'btn btn-goods']
                ) ?>

                <?= Breadcrumbs::widget([
                    'links' => $this->context->breadcrumbs,
                ]) ?>

            </div>
            <div class="cat-content">
                <div class="row">

                    <div class="col-md-12 col-lg-12">
                        <div id="cont_goods" class="cont-area cont-goods">

                            <?php Pjax::begin(['id' => 'factory-product']); ?>

                            <?= GridView::widget([
                                'dataProvider' => $dataProvider,
                                'filterModel' => $filter,
                                'layout' => "{summary}\n{items}\n<div class=\"pagi-wrap\">{pager}</div>",
                                'columns' => [
                                    [
                                        'format' => 'raw',
                                        'attribute' => 'category',
                                        'value' => function ($model) {
                                            $result = [];
                                            foreach ($model->category as $category) {
                                                $result[] = Html::img(
                                                    Category::getImage($category['image_link3']),
                                                    [
                                                        'alt' => $category->lang->title,
                                                        'title' => $category->lang->title
                                                    ]);
                                            }
                                            return implode(', ', $result);
                                        },
                                        'label' => Yii::t('app', 'Category'),
                                        'headerOptions' => ['class' => 'col-sm-1'],
                                        'contentOptions' => ['class' => 'text-center'],
                                        'filter' => GridViewFilter::selectOne(
                                            $filter,
                                            'category',
                                            Category::dropDownList()
                                        ),
                                    ],
                                    [
                                        'attribute' => 'article',
                                        'value' => 'article',
                                        'headerOptions' => ['class' => 'col-sm-1'],
                                        'contentOptions' => ['class' => 'text-center'],
                                    ],
                                    [
                                        'format' => 'raw',
                                        'attribute' => 'image_link',
                                        'value' => function ($model) {
                                            /** @var \frontend\modules\catalog\models\FactoryProduct $model */
                                            return Html::img(Product::getImageThumb($model['image_link']), ['width' => 50]);
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
                                        'format' => 'raw',
                                        'attribute' => 'updated_at',
                                        'label' => Yii::t('app', 'Дата'),
                                        'value' => function ($model) {
                                            return date('j.m.Y', $model->updated_at);
                                        },
                                        'headerOptions' => ['class' => 'col-sm-1'],
                                        'contentOptions' => ['class' => 'text-center'],
                                        'filter' => false
                                    ],
                                    [
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return Html::a(
                                                Yii::t('app', 'Рекламировать'),
                                                Url::toRoute(['/catalog/factory-promotion/create']),
                                                ['class' => 'btn btn-goods']
                                            );
                                        },
                                        'label' => Yii::t('app', 'Рекламировать'),
                                        'filter' => false
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
                                        'template' => '{view} {update} {delete}',
                                        'buttons' => [
                                            'view' => function ($url, $model) {
                                                /** @var $model \frontend\modules\catalog\models\FactoryProduct */
                                                return ($model->published && !$model->deleted) ? Html::a(
                                                    '<span class="glyphicon glyphicon-eye-open"></span>',
                                                    Product::getUrl($model['alias']),
                                                    [
                                                        'class' => 'btn btn-default btn-xs',
                                                        'target' => '_blank'
                                                    ]
                                                ) : '';
                                            },
                                            'update' => function ($url, $model) {
                                                /** @var $model \frontend\modules\catalog\models\FactoryProduct */
                                                return Yii::$app->user->identity->id == $model->user_id ? Html::a(
                                                    '<span class="glyphicon glyphicon-pencil"></span>',
                                                    Url::toRoute(['/catalog/factory-product/update', 'id' => $model->id]),
                                                    [
                                                        'class' => 'btn btn-default btn-xs'
                                                    ]
                                                ) : '';
                                            },
                                            'delete' => function ($url, $model) {
                                                /** @var $model \frontend\modules\catalog\models\FactoryProduct */
                                                return Yii::$app->user->identity->id == $model->user_id ? Html::a(
                                                    '<span class="glyphicon glyphicon-trash"></span>',
                                                    Url::toRoute(['/catalog/factory-product/intrash', 'id' => $model->id]),
                                                    [
                                                        'class' => 'btn btn-default btn-xs',
                                                        'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                                    ]
                                                ) : '';
                                            },
                                        ],
                                        'buttonOptions' => ['class' => 'btn btn-default btn-xs'],
                                        'headerOptions' => ['class' => 'col-sm-1',],
                                    ],
                                ],
                            ]); ?>

                            <?php Pjax::end(); ?>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</main>
