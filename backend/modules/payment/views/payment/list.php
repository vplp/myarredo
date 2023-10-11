<?php

use backend\widgets\GridView\GridView;
use backend\widgets\GridView\gridColumns\ActionColumn;
use backend\modules\payment\models\Payment;
//
use thread\widgets\grid\GridViewFilter;

/**
 * @var $model Payment
 */

echo GridView::widget([
    'dataProvider' => $model->search(Yii::$app->getRequest()->queryParams),
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
            'filter' => GridViewFilter::selectOne($filter, 'type', Payment::getTypeKeyRange()),
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
            'filter' => GridViewFilter::selectOne($filter, 'payment_status', Payment::paymentStatusRange()),
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
            'class' => ActionColumn::class,
        ],
    ],
]);
