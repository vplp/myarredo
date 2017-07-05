<?php

use backend\widgets\GridView\GridView;
//
use thread\widgets\grid\{
    ActionCheckboxColumn, GridViewFilter
};
//
use backend\modules\news\models\Group;

echo GridView::widget([
    'dataProvider' => $model->search(Yii::$app->request->queryParams),
    'filterModel' => $filter,
    'columns' => [
        [
            'class' => \thread\widgets\grid\kartik\EditableColumn::class,
            'attribute' => 'title',
            'displayValue' => function ($model) {
                return $model['lang']['title'];
            },
        ],
        [
            'class' => \thread\widgets\grid\kartik\EditableDropDownColumn::class,
            'attribute' => 'group_id',
            'link' => ['attribute-save-group'],
            'data' => ['0' => '---'] + Group::dropDownList(),
            'displayValue' => function ($model) {
                return $model['group']['lang']['title'];
            },
            'filter' => GridViewFilter::selectOne($filter, 'group_id', ['0' => '---'] + Group::dropDownList()),
        ],
        [
            'attribute' => 'published_time',
            'filter' => GridViewFilter::datePickerRange($filter, 'date_from', 'date_to'),
            'value' => function ($model) {
                return $model->getPublishedTime();
            },
        ],
        [
            'class' => ActionCheckboxColumn::class,
            'attribute' => 'published',
            'action' => 'published'
        ],
        [
            'class' => \backend\widgets\GridView\gridColumns\ActionColumn::class
        ],
    ]
]);
