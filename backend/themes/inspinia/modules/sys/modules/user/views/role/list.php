<?php

use backend\themes\inspinia\widgets\GridView;

echo GridView::widget([
    'dataProvider' => $model->search(Yii::$app->request->queryParams),
    'filterModel' => $filter,
    'columns' => [
        'name',
        'description',
        [
            'class' => \backend\themes\inspinia\widgets\gridColumns\ActionColumn::class,
            'updateLink' => function ($model) {
                return ['update', 'id' => $model->name];
            },
            'deleteLink' => function ($model) {
                return ['update', 'id' => $model->name];
            }
        ],
    ]
]);
