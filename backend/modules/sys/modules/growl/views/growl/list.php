<?php

use yii\grid\GridView;
use yii\helpers\Html;

//
use thread\widgets\grid\{
    ActionEditColumn, ActionToTrashColumn, GridViewFilter
};

echo GridView::widget([
    'dataProvider' => $model->search(Yii::$app->request->queryParams),
    'filterModel' => $filter,
    'columns' => [
        [
            'attribute' => 'type',
            'filter' => GridViewFilter::dropDownList($filter, 'type', $filter::getTypeRange()),
            'format' => 'raw',
            'value' => function ($model) {
                return Html::tag('span', Yii::t('growl', $model['type']), [
                    'class' => 'label label-' . $model['type']
                ]);
            }
        ],
        'model',
        'message',
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
            'class' => ActionToTrashColumn::class,
        ],
    ]
]);
