<?php

use backend\widgets\GridView\GridView;
use backend\modules\payment\models\Payment;

/**
 * @var $model Payment
 */

echo GridView::widget([
    'dataProvider' => $model->search(Yii::$app->getRequest()->queryParams),
    'columns' => [
        'id',
        'user_id',
        [
            'attribute' => 'type',
            'value' => function ($model) {
                /** @var $model Payment */
                return $model->getInvDesc();
            },
            'headerOptions' => ['class' => 'text-center'],
            'contentOptions' => ['class' => 'text-center'],
        ],
        'change_tariff',
        'amount',
        'currency',
        'payment_status',
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
    ],
]);
