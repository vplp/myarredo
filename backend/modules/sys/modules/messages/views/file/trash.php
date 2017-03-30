<?php

use thread\widgets\grid\{
    ActionDeleteColumn, ActionRestoreColumn
};
//
use backend\widgets\GridView\GridView;

/**
 *
 */
echo GridView::widget([
    'dataProvider' => $model->trash(Yii::$app->request->queryParams),
    'tableOptions' => ['class' => 'table table-striped table-bordered'],
    'columns' => [
        'lang.title',
        [
            'class' => ActionDeleteColumn::class,
        ],
        [
            'class' => ActionRestoreColumn::class
        ],
    ]
]);
