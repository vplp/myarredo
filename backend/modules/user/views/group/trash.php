<?php

use yii\grid\GridView;

/**
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
echo GridView::widget([
    'id' => 'grid',
    'dataProvider' => $model->trash(Yii::$app->request->queryParams),
    'columns' => [
        'lang.title',
        [
            'class' => \thread\widgets\grid\ActionRestoreColumn::class,
        ],
        [
            'class' => \thread\widgets\grid\ActionDeleteColumn::class
        ],
    ]
]);
