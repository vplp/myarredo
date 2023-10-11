<?php

use backend\widgets\GridView\GridView;
use thread\widgets\grid\{
    ActionDeleteColumn, ActionRestoreColumn
};
use backend\modules\shop\models\Order;

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
            'attribute' => Yii::t('app', 'Full name'),
            'value' => function ($model) {
                return $model->customer->full_name;
            }
        ],
        [
            'attribute' => Yii::t('app', 'Phone'),
            'value' => function ($model) {
                return $model->customer->phone;
            }
        ],
        [
            'attribute' => Yii::t('app', 'Email'),
            'value' => function ($model) {
                return $model->customer->email;
            }
        ],
        [
            'attribute' => Yii::t('app', 'Country'),
            'value' => function ($model) {
                return $model->country ? $model->country->getTitle() : '-';
            }
        ],
        [
            'attribute' => Yii::t('app', 'City'),
            'value' => function ($model) {
                return $model->city ? $model->city->getTitle() : '-';
            }
        ],
        [
            'attribute' => 'order_status',
            'value' => function ($model) {
                return Order::getOrderStatuses($model->order_status);
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
