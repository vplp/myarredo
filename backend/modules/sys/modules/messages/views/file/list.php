<?php

use yii\grid\GridView;
//
use thread\widgets\grid\{
    ActionEditColumn, ActionToTrashColumn
};

/**
 *
 */
echo GridView::widget([
    'dataProvider' => $model->search(Yii::$app->request->queryParams),
    'filterModel' => $filter,
    'columns' => [
        [
            'label' => Yii::t('app', 'Title'),
            'attribute' => 'title',
            'value' => 'lang.title',
        ],
        'messagefilepath',
//        [
//            'class' => ActionEditColumn::class,
//        ],
//        [
//            'class' => ActionToTrashColumn::class,
//        ],
    ]
]);
