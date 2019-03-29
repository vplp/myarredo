<?php

use backend\widgets\GridView\GridView;
//
use thread\widgets\grid\{
    ActionDeleteColumn, ActionRestoreColumn
};

/**
 * @var \backend\modules\location\models\search\Currency $model
 */

echo GridView::widget([
    'dataProvider' => $model->trash(Yii::$app->request->queryParams),
    'filterModel' => $filter,
    'columns' => [
        [
            'label' => Yii::t('app', 'Title'),
            'attribute' => 'title',
            'value' => 'lang.title',
        ],
        'course',
        'code2',
        [
            'class' => ActionDeleteColumn::class,
        ],
        [
            'class' => ActionRestoreColumn::class
        ],
    ]
]);
