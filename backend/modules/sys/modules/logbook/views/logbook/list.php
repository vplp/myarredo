<?php

use backend\widgets\GridView\GridView;
//
use thread\widgets\grid\{
    ActionCheckboxColumn
};

echo GridView::widget([
    'dataProvider' => $model->search(Yii::$app->request->queryParams),
    'filterModel' => $filter,
    'columns' => [
        [
            'attribute' => 'created_at',
            'value' => function ($model) {
                return date('d.m.Y H:i P', $model['created_at']);
            }
        ],
        [
            'attribute' => 'type',
            'value' => function ($model) {
                return $model::getTypeRange()[$model['type']];
            }
        ],
        [
            'attribute' => 'user_id',
            'value' => 'user.username',
        ],
        'category',
        [
            'attribute' => 'message',
            'format' => 'raw',
        ],
        [
            'class' => ActionCheckboxColumn::class,
            'attribute' => 'is_read',
            'action' => 'is_read'
        ],
        [
            'class' => \backend\widgets\GridView\gridColumns\ActionColumn::class,
        ],
    ]
]);
