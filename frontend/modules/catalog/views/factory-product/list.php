<?php

use yii\helpers\{
    Html, Url
};
use yii\grid\GridView;
use frontend\components\Breadcrumbs;
//
use frontend\modules\catalog\models\{
    Category, Factory
};
//
use thread\widgets\grid\{
    ActionStatusColumn, GridViewFilter
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
            <div class="row">

                <?= Html::tag('h1', $this->context->title); ?>

                <?= Html::a('Добавить', Url::toRoute(['/catalog/factory-product/create']), ['class' => 'btn btn-default']) ?>

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
                                'columns' => [
                                    [
                                        'attribute' => 'category',
                                        'value' => function ($model) {
                                            $result = [];
                                            foreach ($model->category as $category) {
                                                $result[] = ($category->lang) ? $category->lang->title : '(не задано)';
                                            }
                                            return implode(', ', $result);
                                        },
                                        'label' => Yii::t('app', 'Category'),
                                        //'filter' => GridViewFilter::selectOne($filter, 'category', Category::dropDownList()),
                                    ],
                                    [
                                        'attribute' => 'image_link',
                                        'value' => function ($model) {
                                            /** @var \backend\modules\catalog\models\Product $model */
                                            return Html::img($model->getImageLink(), ['width' => 50]);
                                        },
                                        'label' => Yii::t('app', 'Image'),
                                        'format' => 'raw',
                                        'filter' => false
                                    ],
                                    [
                                        'attribute' => 'lang.title',
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            /** @var $model \frontend\modules\catalog\models\Product */
                                            return $model->getTitle();
                                        },
                                    ],
                                    [
                                        'attribute' => 'updated_at',
                                        'value' => function ($model) {
                                            return date('d.n.Y H:i', $model->updated_at);
                                        },
                                        'format' => 'raw',
                                        'filter' => false
                                    ],
//                                    [
//                                        'attribute' => 'published',
//                                        'format' => 'raw',
//                                        'value' => function ($model) {
//                                            /** @var $model \frontend\modules\catalog\models\Product */
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
                                        'template' => '{update} {delete}',
                                        'buttons' => [
                                            'update' => function ($url, $model) {
                                                /** @var $model \frontend\modules\catalog\models\Product */
                                                return Html::a(
                                                    '<span class="glyphicon glyphicon-pencil"></span>',
                                                    Url::toRoute(['/catalog/factory-product/update', 'id' => $model->id]),
                                                    [
                                                        'class' => 'btn btn-default btn-xs'
                                                    ]
                                                );
                                            },
                                            'delete' => function ($url, $model) {
                                                /** @var $model \frontend\modules\catalog\models\Product */
                                                return Html::a(
                                                    '<span class="glyphicon glyphicon-trash"></span>',
                                                    Url::toRoute(['/catalog/factory-product/intrash', 'id' => $model->id]),
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
