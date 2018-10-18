<?php

use backend\widgets\GridView;
use thread\widgets\grid\ActionDeleteColumn;
use thread\widgets\grid\ActionRestoreColumn;

/**
 * @var \backend\modules\forms\models\FormsFeedback $model
 */

echo GridView::widget([
    'dataProvider' => $model->trash(Yii::$app->request->queryParams),
    'tableOptions' => ['class' => 'table table-striped table-bordered'],
    'columns' => [
        'name',
        'phone',
        'email',
        'question',
        [
            'class' => ActionDeleteColumn::class,
        ],
        [
            'class' => ActionRestoreColumn::class
        ],
    ]
]);
