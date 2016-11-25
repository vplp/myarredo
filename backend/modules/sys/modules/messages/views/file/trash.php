<?php

use backend\themes\inspinia\widgets\GridView;

/**
 *
 */
echo GridView::widget([
    'dataProvider' => $model->trash(Yii::$app->request->queryParams),
    'tableOptions' => ['class' => 'table table-striped table-bordered'],
    'columns' => [
        'lang.title',
        [
            'class' => \thread\widgets\grid\ActionDeleteColumn::class,
        ],
        [
            'class' => \thread\widgets\grid\ActionRestoreColumn::class
        ],
    ]
]);
