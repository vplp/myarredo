<?php

use backend\widgets\GridView\GridView;

/**
 * @var $model \backend\modules\sys\modules\logbook\models\Logbook
 * @var $filter \backend\modules\sys\modules\logbook\models\search\Logbook
 */
echo GridView::widget([
    'dataProvider' => $model->trash(Yii::$app->request->queryParams),
    'filterModel' => $filter,
    'columns' => [
        [
            'class' => \backend\widgets\GridView\gridColumns\TrashActionColumn::class,
        ],
    ]
]);
