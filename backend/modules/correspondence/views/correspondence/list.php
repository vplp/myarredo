<?php

use yii\grid\GridView;
//
use thread\widgets\grid\{
    ActionEditColumn, ActionToTrashColumn, ActionCheckboxColumn, GridViewFilter
};

echo GridView::widget([
    'dataProvider' => $model->search(Yii::$app->request->queryParams),
    'filterModel' => $filter,
    'columns' => [
        [
            'attribute' => 'updated_at',
            'filter' => GridViewFilter::datePickerRange($filter, 'date_from', 'date_to'),
            'value' => function ($model) {
                return $model->getPublishedTime();
            },
        ],
        'subject',
        'sender_id',
        'recipient_id',
        [
            'class' => ActionCheckboxColumn::class,
            'attribute' => 'is_read',
            'action' => 'is_read'
        ],
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
    ]
]);
