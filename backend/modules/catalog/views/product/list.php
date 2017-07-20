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
            'attribute' => 'novelty',
            'action' => 'novelty'
        ],
        [
            'class' => ActionStatusColumn::class,
            'attribute' => 'bestseller',
            'action' => 'bestseller'
        ],
        [
            'class' => ActionStatusColumn::class,
            'attribute' => 'onmain',
            'action' => 'onmain'
        ],
        [
            'class' => ActionStatusColumn::class,
            'attribute' => 'published',
            'action' => 'published'
        ],
        [
            'class' => ActionStatusColumn::class,
            'attribute' => 'removed',
            'action' => 'removed'
        ],
        [
            'class' => \backend\widgets\GridView\gridColumns\ActionColumn::class
        ],
    ]
]);
