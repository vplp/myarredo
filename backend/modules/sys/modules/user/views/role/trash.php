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
        'name',
        [
            'class' => ActionDeleteColumn::class,
            'link' => function ($model) {
                return ['update', 'id' => $model->name];
            }
        ],
        [
            'class' => ActionRestoreColumn::class,
            'link' => function ($model) {
                return ['update', 'id' => $model->name];
            }
        ],
    ]
]);
