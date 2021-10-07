<?php

use backend\widgets\GridView\GridView;
use thread\widgets\grid\{GridViewFilter};

/**
 * @var $model \backend\modules\sys\modules\logbook\models\LogbookByMonth
 * @var $filter \backend\modules\sys\modules\logbook\models\search\LogbookByMonth
 */

echo GridView::widget([
    'dataProvider' => $model->search(Yii::$app->getRequest()->getQueryParams()),
    'filterModel' => $filter,
    'columns' => [
        [
            'attribute' => 'user_id',
            'value' => 'user.username',
        ],
        'action_method',
        [
            'attribute' => 'action_date',
            'value' => function ($model) {
                return date('m.Y', $model->action_date);
            }
        ],
        'count',
    ]
]);
