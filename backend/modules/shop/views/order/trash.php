<?php

use backend\widgets\GridView\GridView;
//
use thread\widgets\grid\{
    ActionDeleteColumn, ActionRestoreColumn
};

echo GridView::widget([
    'dataProvider' => $model->trash(Yii::$app->request->queryParams),
    'filterModel' => $filter,
    'columns' => [
        'id',
        [
            'attribute' => 'created_at',
            'value' => function ($model) {
                return $model->getCreatedTime();
            },
        ],
        [
            'attribute' => 'customer',
            'value' => function ($model) {
                return $model->customer->full_name;
            }
        ],
        [
            'attribute' => 'deliveryMethod',
            'value' => function ($model) {
                return $model->deliveryMethod->lang->title;
            }
        ],
        [
            'attribute' => 'paymentMethod',
            'value' => function ($model) {
                return $model->paymentMethod->lang->title;
            }
        ],
        [
            'attribute' => 'order_status',
            'value' => function ($model) {
                return ($model->order_status == '') ? 'Новый' : $model->order_status;
            }
        ],
        [
            'attribute' => 'payd_status',
            'value' => function ($model) {
                return Yii::t('app', $model->payd_status);
            }
        ],
        'total_summ',
        [
            'class' => ActionDeleteColumn::class,
        ],
        [
            'class' => ActionRestoreColumn::class
        ],
    ]
]);