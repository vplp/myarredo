<?php

use backend\themes\inspinia\widgets\GridView;

/**
 *
 */
echo GridView::widget([
    'dataProvider' => $model->search(Yii::$app->request->queryParams),
    'filterModel' => $filter,
    'tableOptions' => ['class' => 'table table-striped table-bordered'],
    'columns' => [
        [
            'label' => Yii::t('app', 'Title'),
            'attribute' => 'title',
            'value' => 'lang.title',
        ],
        'messagefilepath',
        [
            'class' => \backend\themes\inspinia\widgets\gridColumns\ActionColumn::class,
            'deleteLink' => false,
        ],
    ]
]);
