<?php

use thread\widgets\grid\{
    ActionDeleteColumn, ActionRestoreColumn
};
//
use backend\themes\inspinia\widgets\GridView;

echo GridView::widget([
    'dataProvider' => $model->trash(Yii::$app->request->queryParams),
    'filterModel' => $filter,
    'columns' => [
        [
            'attribute' => 'title',
            'value' => 'lang.title',
            'label' => Yii::t('app', 'Title')
        ],
        [
            'class' => ActionDeleteColumn::class,
            'link' => ['group_id', 'id'],
        ],
        [
            'class' => ActionRestoreColumn::class,
            'link' => ['group_id', 'id'],
        ],
    ]
]);
