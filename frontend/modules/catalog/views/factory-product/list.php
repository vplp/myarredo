<?php

use yii\helpers\{
    Html, Url
};
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

                <?= Html::a(Yii::t('app', 'Add'), Url::toRoute(['/catalog/factory-product/create']), ['class' => 'btn btn-default']) ?>

                <?= Breadcrumbs::widget([
                    'links' => $this->context->breadcrumbs,
                ]) ?>

            </div>
            <div class="cat-content">
                <div class="row">

                    <div class="col-md-12 col-lg-12">
                        <div class="cont-area">

                            <?= GridView::widget([
                                'dataProvider' => $dataProvider,
                                'filterModel' => $filter,
                                'layout' => "{summary}\n{items}\n<div class=\"pagi-wrap\">{pager}</div>",
                                'columns' => [
                                    [
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
                                        'format' => 'raw',
                                        'label' => Yii::t('app', 'Category'),
                                        'filter' => GridViewFilter::selectOne($filter, 'category', Category::dropDownList()),
                                    ],
                                    [
                                        'attribute' => 'article',
                                        'value' => 'article',
                                    ],
                                    [
                                        'attribute' => 'image_link',
                                        'value' => function ($model) {
                                            /** @var \frontend\modules\catalog\models\FactoryProduct $model */
                                            return Html::img(Product::getImageThumb($model['image_link']), ['width' => 50]);
                                        },
                                        'format' => 'raw',
                                        'filter' => false
                                    ],
                                    [
                                        'attribute' => 'title',
                                        'value' => 'lang.title',
                                        'label' => Yii::t('app', 'Title'),
                                    ],
                                    [
                                        'attribute' => 'updated_at',
                                        'value' => function ($model) {
                                            return date('j.m.Y', $model->updated_at);
                                        },
                                        'format' => 'raw',
                                        'filter' => false
                                    ],
//                                    [
//                                        'attribute' => 'published',
//                                        'format' => 'raw',
//                                        'value' => function ($model) {
//                                            /** @var $model \frontend\modules\catalog\models\FactoryProduct */
//                                            return ($model->published) ? 1 : 0;
//                                        },
//                                        'headerOptions' => ['class' => 'col-sm-1',],
//                                        'contentOptions' => ['class' => 'text-center',],
//                                    ],
                                    [
                                        'class' => ActionStatusColumn::class,
                                        'attribute' => 'published',
                                        'action' => 'published'
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

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</main>
