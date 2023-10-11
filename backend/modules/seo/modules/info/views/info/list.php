<?php

use backend\widgets\GridView\GridView;

//
echo GridView::widget([
    'dataProvider' => $model->search(Yii::$app->request->queryParams),
    'filterModel' => $filter,
    'columns' => [
        'alias',
        [
            'attribute' => 'title',
            'value' => function ($model) {
                return $model->getTitle();
            },
        ],
        'lang.value',
        [
            'class' => \backend\widgets\GridView\gridColumns\ActionColumn::class,
            'deleteLink' => function () {
                return false;
            }
        ],
    ]
]);
