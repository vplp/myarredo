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
 * @var $model \backend\modules\menu\models\MenuItem
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
        ],
        [
            'class' => ActionRestoreColumn::class
        ],
    ]
]);
