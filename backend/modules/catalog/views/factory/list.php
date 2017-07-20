<?php

use thread\widgets\grid\{
    ActionStatusColumn
};
//
use backend\widgets\GridView\GridView;

echo GridView::widget([
    'dataProvider' => $model->search(Yii::$app->request->queryParams),
    'filterModel' => $filter,
    'columns' => [
        [
            'attribute' => Yii::t('app', 'Title'),
            'value' => 'lang.title',
        ],
        [
            'class' => ActionStatusColumn::class,
            'attribute' => 'popular',
            'action' => 'popular'
        ],
        [
            'class' => ActionStatusColumn::class,
            'attribute' => 'popular_by',
            'action' => 'popular_by'
        ],
        [
            'class' => ActionStatusColumn::class,
            'attribute' => 'popular_ua',
            'action' => 'popular_ua'
        ],
        [
            'class' => \backend\widgets\GridView\gridColumns\ActionColumn::class
        ],
    ]
]);
