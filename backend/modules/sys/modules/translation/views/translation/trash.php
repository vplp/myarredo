<?php
use thread\widgets\grid\{
    ActionDeleteColumn, ActionRestoreColumn
};
//
use backend\widgets\GridView\GridView;
use backend\modules\sys\modules\translation\models\Source;
use backend\modules\sys\modules\translation\models\search\Source as SourceSearch;

/** @var Source $model */
/** @var SourceSearch $filter */

echo GridView::widget([
    'dataProvider' => $model->trash(Yii::$app->request->queryParams),
    'filterModel' => $filter,
    'columns' => [
        'category',
        'key',
        [
            'class' => ActionDeleteColumn::class,
        ],
        [
            'class' => ActionRestoreColumn::class
        ],
    ]
]);
