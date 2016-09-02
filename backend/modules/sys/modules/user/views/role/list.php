<?php

use yii\grid\GridView;
//
use thread\widgets\grid\{
    ActionEditColumn, ActionToTrashColumn
};

echo GridView::widget([
    'dataProvider' => $model->search(Yii::$app->request->queryParams),
    'filterModel' => $filter,
    'columns' => [
        'name',
        'description',
        [
            'class' => ActionEditColumn::class,
            'link' => function ($model) {
                return ['update', 'id' => $model->name];
            }
        ],
        [
            'class' => ActionToTrashColumn::class,
            'link' => function ($model) {
                return ['update', 'id' => $model->name];
            }
        ],
    ]
]);
