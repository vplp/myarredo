<?php

use thread\widgets\grid\ActionDeleteColumn;
use thread\widgets\grid\ActionRestoreColumn;
use backend\themes\inspinia\widgets\GridView;

/**
 *
 * @package admin\modules\page\view
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */

echo GridView::widget([
    'dataProvider' => $model->trash(Yii::$app->request->queryParams),
    'columns' => [
        'alpha2',
        'alpha3',
        'lang.title',
        [
            'class' =>  ActionDeleteColumn::class,
        ],
        [
            'class' =>  ActionRestoreColumn::class
        ],
    ]
]);
