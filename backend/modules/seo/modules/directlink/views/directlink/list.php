<?php

use backend\widgets\GridView\GridView;
//
use thread\widgets\grid\{
    ActionStatusColumn
};

echo GridView::widget([
    'dataProvider' => $model->search(Yii::$app->request->queryParams),
    'filterModel' => $filter,
    'columns' => [
        'url',
        /*[
            'class' => ActionStatusColumn::class,
            'attribute' => 'add_to_sitemap',
            'action' => 'add_to_sitemap'
        ],
        [
            'class' => ActionStatusColumn::class,
            'attribute' => 'dissallow_in_robotstxt',
            'action' => 'dissallow_in_robotstxt'
        ],*/
        [
            'class' => ActionStatusColumn::class,
            'attribute' => 'published',
            'action' => 'published'
        ],
        [
            'class' => \backend\widgets\GridView\gridColumns\ActionColumn::class,
        ],
    ]
]);
