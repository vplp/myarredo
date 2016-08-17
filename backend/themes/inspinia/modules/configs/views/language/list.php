<?php

use yii\helpers\Html;
//
use thread\widgets\grid\{
    ActionCheckboxColumn
};
//
use backend\themes\inspinia\widgets\GridView;

echo GridView::widget([
    'dataProvider' => $model->search(Yii::$app->request->queryParams),
    'filterModel' => $filter,
    'columns' => [
        [
            'attribute' => 'img_flag',
            'format' => 'raw',
            'value' => function ($data) {
                return Html::img($data->getFlagUploadUrl());
            },
        ],
        'alias',
        'label',
        'local',
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
