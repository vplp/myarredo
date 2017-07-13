<?php

use backend\widgets\GridView\GridView;

echo GridView::widget([
    'dataProvider' => $model->search(Yii::$app->request->queryParams),
    'filterModel' => $filter,
    'columns' => [
        'name',
        'description',
        [
            'class' => \backend\widgets\GridView\gridColumns\ActionColumn::class,
            'updateLink' => function ($model) {
                return ['update', 'id' => $model->name];
            },
            'deleteLink' => function ($model) {
                return ['update', 'id' => $model->name];
            }
        ],
    ]
]);
