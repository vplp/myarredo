<?php

use backend\widgets\GridView\GridView;
//
use thread\widgets\grid\{
    GridViewFilter
};
use backend\modules\sys\modules\configs\models\Group;

echo GridView::widget([
    'dataProvider' => $model->search(Yii::$app->request->queryParams),
    'filterModel' => $filter,
    'columns' => [
        [
            'attribute' => 'group_id',
            'value' => 'group.lang.title',
            'filter' => GridViewFilter::selectOne($filter, 'group_id', Group::dropDownList())
        ],
        [
            'attribute' => 'title',
            'value' => 'lang.title',
        ],
        'value',
        [
            'class' => \backend\widgets\GridView\gridColumns\ActionColumn::class
        ],
    ]
]);
