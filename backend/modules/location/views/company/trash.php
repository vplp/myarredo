<?php

use thread\widgets\grid\ActionDeleteColumn;
use thread\widgets\grid\ActionRestoreColumn;
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
        'lang.street',
        'lang.house',
        [
            'attribute' => 'country_id',
            'value' => 'country.lang.title',
        ],
        [
            'attribute' => 'city_id',
            'value' => 'city.lang.title',
        ],
        [
            'class' =>  ActionDeleteColumn::class,
        ],
        [
            'class' =>  ActionRestoreColumn::class
        ],
    ]
]);
