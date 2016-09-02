<?php

use thread\widgets\grid\{
    GridViewFilter
};
//
use backend\themes\inspinia\widgets\GridView;

echo GridView::widget([
    'dataProvider' => $model->search(Yii::$app->request->queryParams),
    'filterModel' => $filter,
    'columns' => [
        'model',
        'user_id',
        [
            'attribute' => 'type',
            'filter' => GridViewFilter::dropDownList($filter, 'type', $filter::getTypeRange()),
        ],
        'message',
        'is_read',
        [
            'class' => \backend\themes\inspinia\widgets\gridColumns\ActionColumn::class,
        ],
    ]
]);
