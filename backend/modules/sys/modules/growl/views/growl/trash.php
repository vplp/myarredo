<?php
use thread\widgets\grid\kartik\GridView;
//
use thread\widgets\grid\{
    ActionDeleteColumn, ActionRestoreColumn
};

echo GridView::widget([
    'dataProvider' => $model->trash(Yii::$app->request->queryParams),
    'filterModel' => $filter,
    'columns' => [
        [
            'attribute' => 'type',
            'filter' => GridViewFilter::dropDownList($filter, 'type', $filter::getTypeRange()),
        ],
        'model',
        'message',
        [
            'class' => ActionDeleteColumn::class,
        ],
        [
            'class' => ActionRestoreColumn::class,
        ],
    ]
]);
