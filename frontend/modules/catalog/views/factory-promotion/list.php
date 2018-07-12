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
 * @var $model \frontend\modules\catalog\models\FactoryPromotion
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
                    Url::toRoute(['/catalog/factory-promotion/create']),
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

                            <?php Pjax::begin(['id' => 'factory-promotion']); ?>

                            <?= GridView::widget([
                                'dataProvider' => $dataProvider,
                                'filterModel' => $filter,
                                'layout' => "{summary}\n{items}\n<div class=\"pagi-wrap\">{pager}</div>",
                                'columns' => [
                                    [
                                        'attribute' => 'id',
                                        'value' => 'id',
                                        'headerOptions' => ['class' => 'col-sm-1'],
                                        'contentOptions' => ['class' => 'text-center'],
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
                                        'label' => Yii::t('app', 'Список товаров'),
                                        'value' => function ($model) {
                                            /** @var \frontend\modules\catalog\models\FactoryPromotion $model */
                                            $result = [];
                                            foreach ($model->products as $product) {
                                                $result[] = $product->lang->title;
                                            }
                                            return implode(' | ', $result);
                                        },
                                    ],
                                    [
                                        'format' => 'raw',
                                        'label' => Yii::t('app', 'Кол-во городов'),
                                        'value' => function ($model) {
                                            /** @var \frontend\modules\catalog\models\FactoryPromotion $model */
                                            return count($model->cities);
                                        },
                                    ],
                                    [
                                        'attribute' => 'cost',
                                        'value' => 'cost',
                                        'label' => Yii::t('app', 'Бюджет'),
                                        'headerOptions' => ['class' => 'col-sm-1'],
                                        'contentOptions' => ['class' => 'text-center'],
                                    ],
                                    [
                                        'attribute' => 'status',
                                        'value' => function ($model) {
                                            /** @var \frontend\modules\catalog\models\FactoryPromotion $model */
                                            return $model->status ? 'Активная' : 'Завершена';
                                        },
                                        'headerOptions' => ['class' => 'col-sm-1'],
                                        'contentOptions' => ['class' => 'text-center'],
                                        'filter' => GridViewFilter::selectOne(
                                            $filter,
                                            'status',
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
                                                /** @var $model \frontend\modules\catalog\models\FactoryPromotion */
                                                return Yii::$app->user->identity->id == $model->user_id ? Html::a(
                                                    '<span class="glyphicon glyphicon-pencil"></span>',
                                                    Url::toRoute(['/catalog/factory-promotion/update', 'id' => $model->id]),
                                                    [
                                                        'class' => 'btn btn-default btn-xs'
                                                    ]
                                                ) : '';
                                            },
                                            'delete' => function ($url, $model) {
                                                /** @var $model \frontend\modules\catalog\models\FactoryPromotion */
                                                return Yii::$app->user->identity->id == $model->user_id ? Html::a(
                                                    '<span class="glyphicon glyphicon-trash"></span>',
                                                    Url::toRoute(['/catalog/factory-promotion/intrash', 'id' => $model->id]),
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
