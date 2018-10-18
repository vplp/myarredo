<?php

use yii\helpers\{
    Html, Url
};
use kartik\grid\GridView;
use frontend\components\Breadcrumbs;
use thread\widgets\grid\{
    GridViewFilter
};
use frontend\modules\catalog\models\FactoryPromotion;

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

                <?= Html::tag('span', '<i class="fa fa-question-circle"></i>', [
                    'title' => Yii::$app->param->getByName('FACTORY_PROMOTION_TOOLTIP1'),
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'bottom',
                    'class' => 'tooltip-info'
                ]) ?>

                <?= Breadcrumbs::widget([
                    'links' => $this->context->breadcrumbs,
                ]) ?>

            </div>
            <div class="cat-content">
                <div class="row">

                    <div class="col-md-12 col-lg-12">
                        <div class="cont-area cont-goods">
                            <?php if (!empty($dataProvider->models)) { ?>
                                <?= GridView::widget([
                                    'dataProvider' => $dataProvider,
                                    'filterModel' => $filter,
                                    'layout' => "{summary}\n{items}\n<div class=\"pagi-wrap\">{pager}</div>",
                                    'filterUrl' => Url::toRoute(['/catalog/factory-promotion/list']),
                                    'columns' => [
                                        [
                                            'format' => 'raw',
                                            'attribute' => 'updated_at',
                                            'label' => Yii::t('app', 'Дата'),
                                            'value' => function ($model) {
                                                return date('j.m.Y', $model->updated_at);
                                            },
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
                                            'attribute' => 'amount',
                                            'value' => 'amount',
                                        ],
                                        [
                                            'attribute' => 'payment_status',
                                            'value' => function ($model) {
                                                /** @var \backend\modules\catalog\models\FactoryPromotion $model */
                                                return $model->getPaymentStatusTitle();
                                            },
                                            'filter' => GridViewFilter::selectOne(
                                                $filter,
                                                'payment_status',
                                                $model::paymentStatusKeyRange()
                                            ),
                                        ],
                                        [
                                            'attribute' => 'status',
                                            'value' => function ($model) {
                                                /** @var \frontend\modules\catalog\models\FactoryPromotion $model */
                                                return $model->getStatusTitle();
                                            },
                                            'filter' => GridViewFilter::selectOne(
                                                $filter,
                                                'status',
                                                [
                                                    0 => Yii::t('app', 'Завершена'),
                                                    1 => Yii::t('app', 'Активная')
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
                                                        Url::toRoute([
                                                            '/catalog/factory-promotion/update',
                                                            'id' => $model->id
                                                        ]),
                                                        [
                                                            'class' => 'btn btn-default btn-xs'
                                                        ]
                                                    ) : '';
                                                },
                                                'delete' => function ($url, $model) {
                                                    /** @var $model \frontend\modules\catalog\models\FactoryPromotion */
                                                    return (
                                                        Yii::$app->user->identity->id == $model->user_id &&
                                                        $model->payment_status != FactoryPromotion::PAYMENT_STATUS_PAID)
                                                        ? Html::a(
                                                            '<span class="glyphicon glyphicon-trash"></span>',
                                                            Url::toRoute([
                                                                '/catalog/factory-promotion/intrash',
                                                                'id' => $model->id
                                                            ]),
                                                            [
                                                                'class' => 'btn btn-default btn-xs',
                                                                'data-confirm' => Yii::t(
                                                                    'yii',
                                                                    'Are you sure you want to delete this item?'
                                                                ),
                                                            ]
                                                        )
                                                        : '';
                                                },
                                            ],
                                            'buttonOptions' => ['class' => 'btn btn-default btn-xs'],
                                            'headerOptions' => ['class' => 'col-sm-1',],
                                        ],
                                    ],
                                ]) ?>
                            <?php } else { ?>
                                <div class="text-center">
                                    <?= Yii::t('yii', 'No results found.'); ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</main>
