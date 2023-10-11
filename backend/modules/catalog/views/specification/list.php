<?php

use thread\widgets\grid\ActionStatusColumn;
use backend\widgets\TreeGrid;

echo TreeGrid::widget([
    'dataProvider' => $model->search(Yii::$app->request->queryParams),
    'keyColumnName' => 'id',
    'parentColumnName' => 'parent_id',
    'options' => ['class' => 'table table-striped table-bordered'],
    'columns' => [
        [
            'attribute' => 'title',
            'value' => 'lang.title',
            'label' => Yii::t('app', 'Title'),
        ],
        'position',
        [
            'class' => ActionStatusColumn::class,
            'attribute' => 'published',
            'action' => 'published'
        ],
        [
            'class' => \backend\widgets\gridColumns\ActionColumn::class
        ],
    ]
]);
