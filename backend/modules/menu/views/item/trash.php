<?php

use thread\widgets\grid\{
    ActionDeleteColumn, ActionRestoreColumn
};
//
use backend\themes\inspinia\widgets\GridView;

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
            'class' => ActionDeleteColumn::class,
            'link' => ['group_id', 'parent_id', 'id'],
        ],
        [
            'class' => ActionRestoreColumn::class,
            'link' => ['group_id', 'parent_id', 'id'],
        ],
    ]
]);
