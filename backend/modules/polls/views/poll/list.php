<?php

use yii\helpers\Html;
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
            'attribute' => 'title',
            'value' => 'lang.title',
            'label' => Yii::t('app', 'Title'),
        ],
        [
            'attribute' => 'start_time',
            'filter' => GridViewFilter::datePickerRange($filter, 'start_date_from', 'start_date_to'),
            'value' => function ($model) {
                return $model->getStartTime();
            },
        ],
        [
            'attribute' => 'finish_time',
            'filter' => GridViewFilter::datePickerRange($filter, 'finish_date_from', 'finish_date_to'),
            'value' => function ($model) {
                return $model->getFinishTime();
            },
        ],
        [
            'format' => 'raw',
            'value' => function ($model) {
                return Html::a(
                    Yii::t('app', 'Votes') . ': ' . ' (' . $model->getVotesCount() . ')',
                    ['/polls/vote/list', 'group_id' => $model['id']]
                );
            }
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
