<?php

use yii\grid\GridView;
//
use thread\widgets\grid\{
    ActionEditColumn, ActionToTrashColumn, GridViewFilter
};

echo GridView::widget([
    'dataProvider' => $model->search(Yii::$app->request->queryParams),
    'filterModel' => $filter,
    'columns' => [
        'model',
        'user_id',
        [
            'attribute' => 'type',
            'filter' => GridViewFilter::dropDownList($filter, 'type', $filter::getTypeRange() ),
        ],
        'message',
        'is_read',
        [
            'class' => ActionEditColumn::class,
        ],
        [
            'class' => ActionToTrashColumn::class,
        ],
    ]
]);
