<?php

use backend\themes\inspinia\widgets\GridView;

echo GridView::widget([
    'dataProvider' => $model->trash(Yii::$app->request->queryParams),
    'filterModel' => $filter,
    'columns' => [
        [
            'attribute' => 'title',
            'value' => 'lang.title',
            'label' => Yii::t('app', 'Title'),
        ],
        [
            'class' => \thread\widgets\grid\ActionDeleteColumn::class,
        ],
        [
            'class' => \thread\widgets\grid\ActionRestoreColumn::class
        ],
    ]
]);
