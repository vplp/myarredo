<?php

use backend\widgets\GridView\GridView;
//
use thread\widgets\grid\{
    ActionDeleteColumn, ActionRestoreColumn
};

/**
 *
 * @package admin\modules\page\view
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 *
 * @var $model \backend\modules\menu\models\Menu
 */

echo GridView::widget([
    'dataProvider' => $model->trash(Yii::$app->request->queryParams),
    'filterModel' => $filter,
    'columns' => [
        [
            'attribute' => 'title',
            'value' => 'lang.title',
        ],
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
