<?php

use thread\widgets\grid\ActionDeleteColumn;
use thread\widgets\grid\ActionRestoreColumn;
use backend\themes\defaults\widgets\GridView;

/**
 *
 * @package admin\modules\page\view
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */

echo GridView::widget([
    'dataProvider' => $model->trash(Yii::$app->request->queryParams),
    'columns' => [
        'lang.title',
        [
            'class' =>  ActionDeleteColumn::class,
        ],
        [
            'class' =>  ActionRestoreColumn::class
        ],
    ]
]);
