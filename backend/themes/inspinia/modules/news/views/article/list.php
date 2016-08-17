<?php

use thread\widgets\grid\{
    ActionCheckboxColumn, GridViewFilter
};
//
use backend\themes\inspinia\widgets\GridView;

/**
 * @var \backend\modules\news\models\search\Article $model
 */

echo GridView::widget([
    'dataProvider' => $model->search(Yii::$app->request->queryParams),
    'filterModel' => $filter,
    'columns' => [
        [
            'attribute' => 'group_id',
            'value' => 'group.lang.title',
            'filter' => GridViewFilter::dropDownList($filter, 'group_id', \backend\modules\news\models\Group::dropDownList()),
        ],
        [
            'attribute' => 'title',
            'value' => 'lang.title',
            'label' => Yii::t('app', 'Title'),
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
            'class' => \backend\themes\inspinia\widgets\gridColumns\ActionColumn::class
        ],
    ]
]);
