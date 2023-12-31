<?php

use backend\widgets\GridView\GridView;
//
use thread\widgets\grid\{
    ActionDeleteColumn, ActionRestoreColumn
};

/**
 * @var \backend\modules\user\models\User $model
 */
echo GridView::widget([
    'dataProvider' => $model->trash(Yii::$app->request->queryParams),
    'filterModel' => $filter,
    'columns' => [
        [
            'attribute' => 'group_id',
            'value' => 'group.lang.title'
        ],
        'email',
        [
            'class' => ActionRestoreColumn::class,
        ],
        [
            'class' => ActionDeleteColumn::class
        ],
    ]
]);
