<?php

use backend\widgets\GridView\GridView;

echo GridView::widget([
    'dataProvider' => $model->search(Yii::$app->request->queryParams),
    'filterModel' => $filter,
    'columns' => [
        [
            'attribute' => 'title',
            'value' => 'lang.title',
            'label' => Yii::t('app', 'Title'),
        ],
        'updated_at:datetime',
        [
            'class' => \backend\widgets\GridView\gridColumns\ActionColumn::class
        ],
    ]
]);
