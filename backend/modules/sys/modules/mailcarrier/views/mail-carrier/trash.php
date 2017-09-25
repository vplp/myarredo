<?php
use backend\widgets\GridView\GridView;
//
use thread\widgets\grid\{
    ActionDeleteColumn, ActionRestoreColumn
};

/**
 * @var $model \backend\modules\news\models\Group
 * @var $filter \backend\modules\news\models\search\Group
 */
echo GridView::widget([
    'dataProvider' => $model->trash(Yii::$app->request->queryParams),
    'filterModel' => $filter,
    'columns' => [
        [
            'attribute' => 'title',
            'value' => 'lang.title',
        ],
        [
            'class' => ActionDeleteColumn::class,
        ],
        [
            'class' => ActionRestoreColumn::class
        ],
    ]
]);
