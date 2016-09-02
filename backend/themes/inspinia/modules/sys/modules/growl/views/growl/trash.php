<?php

use thread\widgets\grid\{
    ActionDeleteColumn, ActionRestoreColumn
};
//
use backend\themes\inspinia\widgets\GridView;

echo GridView::widget([
    'dataProvider' => $model->trash(Yii::$app->request->queryParams),
    'filterModel' => $filter,
    'columns' => [
        'model',
        'user_id',
        'type',
        'message',
        'is_read',
        [
            'class' => ActionDeleteColumn::class,
        ],
        [
            'class' => ActionRestoreColumn::class,
        ],
    ]
]);
