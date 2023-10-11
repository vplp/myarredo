<?php

use backend\widgets\GridView\GridView;
//
use thread\widgets\grid\{
    ActionDeleteColumn, ActionRestoreColumn
};
use backend\modules\payment\models\Payment;

/**
 * @var $model Payment
 */


echo GridView::widget([
    'dataProvider' => $model->trash(Yii::$app->request->queryParams),
    'filterModel' => $filter,
    'columns' => [
        'id',
        'user_id',
        [
            'attribute' => 'type',
            'value' => function ($model) {
                /** @var $model Payment */
                return $model->getInvDesc();
            },
        ],
        'change_tariff',
        'amount',
        'currency',
        [
            'attribute' => 'payment_status',
            'value' => function ($model) {
                /** @var $model Payment */
                return $model->payment_status;
            },
        ],
        [
            'attribute' => 'payment_time',
            'value' => function ($model) {
                /** @var $model Payment */
                return $model['payment_time'] ? date('d.m.Y H:i', $model['payment_time']) : '';
            }
        ],
        [
            'attribute' => 'created_at',
            'value' => function ($model) {
                /** @var $model Payment */
                return date('d.m.Y H:i', $model['created_at']);
            }
        ],
        [
            'class' => ActionDeleteColumn::class,
        ],
        [
            'class' => ActionRestoreColumn::class
        ],
    ]
]);
