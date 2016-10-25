<?php

use yii\grid\GridView;
//
use thread\widgets\grid\{
    ActionEditColumn, ActionToTrashColumn, ActionCheckboxColumn
};
/**
 *
 * @package backend\modules\shop\view
 * @author Alla Kuzmenko
 * @copyright (c) 2015, Thread
 *
 */
echo GridView::widget([
    'dataProvider' => $model->search(Yii::$app->getRequest()->queryParams),
    'columns' => [
        'lang.title',
        'position',
        [
            'class' => ActionCheckboxColumn::class,
            'attribute' => 'published',
            'action' => 'published'
        ],
        [
            'class' => ActionEditColumn::class,
        ],
        [
            'class' => ActionToTrashColumn::class
        ],
    ],
]);
