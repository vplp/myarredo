<?php

use yii\grid\GridView;
//
use thread\widgets\grid\{
    ActionEditColumn, ActionToTrashColumn
};

/**
 *
 */
echo GridView::widget([
    'dataProvider' => $model->search(Yii::$app->request->queryParams),
    'filterModel' => $filter,
    'columns' => [
        'lang.title',
        'messagefilepath',
        [
            'class' => ActionEditColumn::class,
        ],
        [
            'class' => ActionToTrashColumn::class,
        ],
    ]
]);
