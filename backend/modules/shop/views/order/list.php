<?php

use backend\widgets\GridView\GridView;

echo GridView::widget([
    'dataProvider' => $model->search(Yii::$app->getRequest()->queryParams),
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
            'attribute' => Yii::t('app', 'City'),
            'value' => function ($model) {
                return $model->city->lang->title ?? '';
            }
        ],
        [
            'attribute' => 'order_status',
            'value' => function ($model) {
                return $model->getOrderStatus();
            }
        ],
        [
            'class' => \backend\widgets\GridView\gridColumns\ActionColumn::class,
        ],
    ],
]);