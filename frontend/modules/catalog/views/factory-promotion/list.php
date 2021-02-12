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
 * @var $model FactoryPromotion
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
                                            'attribute' => 'start_date_promotion',
                                            'value' => function ($model) {
                                                /** @var $model FactoryPromotion */
                                                return $model->start_date_promotion
                                                    ? date('j.m.Y', $model->start_date_promotion)
                                                    : '';
                                            },
                                            'filter' => false
                                        ],
                                        [
                                            'format' => 'raw',
                                            'attribute' => 'end_date_promotion',
                                            'value' => function ($model) {
                                                /** @var $model FactoryPromotion */
                                                return $model->end_date_promotion
                                                    ? date('j.m.Y', $model->end_date_promotion)
                                                    : '';
                                            },
                                            'filter' => false
                                        ],
                                        [
                                            'format' => 'raw',
                                            'label' => Yii::t('app', 'Список товаров'),
                                            'value' => function ($model) {
                                                /** @var $model FactoryPromotion */
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
                                                /** @var $model FactoryPromotion */
                                                return count($model->cities);
                                            },
                                        ],
                                        [
                                            'format' => 'html',
                                            'label' => Yii::t('app', 'Factory statistics'),
                                            'value' => function ($model) {
                                                /** @var $model FactoryPromotion */
                                                if ($model->status == FactoryPromotion::STATUS_COMPLETED) {
                                                    return Html::a(
                                                        Yii::t('app', 'View'),
                                                        Url::toRoute([
                                                            '/catalog/factory-stats/view',
                                                            'alias' => $model['factory']['alias'],
                                                            'start_date' => date('j-m-Y', $model->start_date_promotion),
                                                            'end_date' => date('j-m-Y', $model->end_date_promotion),
                                                        ])
                                                    );
                                                } else {
                                                    return false;
                                                }
                                            },
                                        ],
                                        [
                                            'attribute' => 'amount',
                                            'format' => 'html',
                                            //'value' => 'amount',
                                            'value' => function ($model) {
                                                /** @var $model FactoryPromotion */
                                                if ($model->status != FactoryPromotion::STATUS_COMPLETED) {
                                                    return $model['amount'] . '<br>' . Html::a(
                                                        Yii::t('app', 'Оплатить'),
                                                        Url::toRoute([
                                                            '/catalog/factory-promotion/payment',
                                                            'id' => $model['id']
                                                        ])
                                                    );
                                                } else {
                                                    return $model['amount'];
                                                }
                                            },
                                        ],
                                        [
                                            'attribute' => 'views',
                                            'label' => Yii::t('app', 'Заказано просмотров'),
                                            'value' => 'views',
                                        ],
                                        [
                                            'attribute' => 'payment_status',
                                            'value' => function ($model) {
                                                /** @var $model FactoryPromotion */
                                                return $model->getPaymentStatusTitle();
                                            },
                                            'filter' => false
                                        ],
                                        [
                                            'attribute' => 'status',
                                            'value' => function ($model) {
                                                /** @var $model FactoryPromotion */
                                                return $model->getStatusTitle();
                                            },
                                            'filter' => false
                                        ],
                                        [
                                            'class' => yii\grid\ActionColumn::class,
                                            'template' => '{update} {delete}',
                                            'buttons' => [
                                                'update' => function ($url, $model) {
                                                    /** @var $model FactoryPromotion */
                                                    return Yii::$app->user->identity->id == $model->user_id ? Html::a(
                                                        '<i class="fa fa-pencil" aria-hidden="true"></i>',
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
                                                    /** @var $model FactoryPromotion */
                                                    return (
                                                        Yii::$app->user->identity->id == $model->user_id &&
                                                        $model->payment_status != FactoryPromotion::PAYMENT_STATUS_SUCCESS)
                                                        ? Html::a(
                                                            '<i class="fa fa-trash" aria-hidden="true"></i>',
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
