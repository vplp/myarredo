<?php

use yii\helpers\{ArrayHelper, Html, Url};
use kartik\grid\GridView;
use frontend\modules\shop\models\OrderComment;

/**
 * @var $dataProvider OrderComment
 */

$this->title = $this->context->title;

?>

<main>
    <div class="page category-page">
        <div class="container large-container">
            <div class="row title-cont">

                <?= Html::tag('h1', $this->context->title); ?>

            </div>
            <div class="cat-content">
                <div class="row">
                    <div class="col-md-12 col-lg-12">


                        <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'layout' => "{items}\n<div class=\"pagi-wrap\">{pager}</div>",
                            'filterUrl' => Url::toRoute(['/catalog/factory-prices-files/list']),
                            'columns' => [
                                [
                                    'attribute' => 'reminder_time',
                                    'value' => function ($model) {
                                        /** @var $model OrderComment */
                                        return date('j.m.Y', $model->reminder_time);
                                    },
                                    'headerOptions' => ['class' => 'col-sm-1'],
                                    'contentOptions' => ['class' => 'text-center'],
                                    'format' => 'raw',
                                    'filter' => false
                                ],
                                'content',
                                [
                                    'value' => function ($model) {
                                        /** @var $model OrderComment */
                                        return Html::a(
                                            Yii::t('shop', 'Обработано'),
                                            Url::toRoute([
                                                '/shop/order-comment/processed',
                                                'id' => $model['id']
                                            ]),
                                            [
                                                'class' => 'btn btn-default btn-xs'
                                            ]
                                        );
                                    },
                                    'headerOptions' => ['class' => 'col-sm-1'],
                                    'contentOptions' => ['class' => 'text-center'],
                                    'format' => 'raw',
                                    'filter' => false
                                ],
                                [
                                    'class' => yii\grid\ActionColumn::class,
                                    'template' => '{update}',
                                    'buttons' => [
                                        'update' => function ($url, $model) {
                                            /** @var $model OrderComment */
                                            return (empty($model->product))
                                                ? Html::a(
                                                    '<i class="fa fa-pencil" aria-hidden="true"></i>',
                                                    Url::toRoute([
                                                        '/shop/admin-order/manager',
                                                        'id' => $model['order_id']
                                                    ]),
                                                    [
                                                        'class' => 'btn btn-default btn-xs'
                                                    ]
                                                )
                                                : '';
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
