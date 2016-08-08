<?php

use backend\themes\inspinia\widgets\GridView;

/**
 *
 * @package admin\modules\page\view
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 *
 */
echo GridView::widget([
    'dataProvider' => $model->trash(Yii::$app->request->queryParams),

    'columns' => [
        [
            'attribute' => 'title',
            'value' => 'lang.title',
            'label' => Yii::t('app', 'Title'),
        ],
        [
            'class' => \thread\widgets\grid\ActionDeleteColumn::class,
        ],
        [
            'class' => \thread\widgets\grid\ActionRestoreColumn::class
        ],
    ]
]);
