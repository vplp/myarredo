<?php

use yii\grid\GridView;

/**
 * @var \backend\modules\user\models\User $model
 */
echo GridView::widget([
    'id' => 'grid',
    'dataProvider' => $model->trash(Yii::$app->request->queryParams),
    'columns' => [
        [
            'attribute' => 'group_id',
            'value' => 'group.lang.title'
        ],
        'username',
        [
            'class' => \thread\widgets\grid\ActionRestoreColumn::class,
        ],
        [
            'class' => \thread\widgets\grid\ActionDeleteColumn::class
        ],
    ]
]);
