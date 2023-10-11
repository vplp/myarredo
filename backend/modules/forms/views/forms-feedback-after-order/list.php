<?php

use backend\widgets\GridView;
use backend\widgets\gridColumns\ActionColumn;
use backend\modules\forms\models\FormsFeedbackAfterOrder;
use backend\modules\user\models\User;
use thread\widgets\grid\{
    ActionStatusColumn
};

/**
 * @var FormsFeedback $model
 */

echo GridView::widget([
    'dataProvider' => $model->search(Yii::$app->request->queryParams),
    'tableOptions' => ['class' => 'table table-striped table-bordered'],
    'columns' => [
        [
            'attribute' => 'created_at',
            'value' => function ($model) {
                return $model->getPublishedTime();
            },
        ],
        [
            'attribute' => 'user_id',
            'value' => function ($model) {
                if ($model->user){
                    return $model->user->profile->first_name . (!empty($model->user->profile->last_name) ? ' '.$model->user->profile->last_name : '');
                } else {
                    return $model->customer->full_name;
                }
            },
        ],
        'order_id',
        [
            'class' => ActionStatusColumn::class,
            'attribute' => 'published',
            'action' => 'published'
        ],
        [
            'class' => ActionColumn::class
        ],
    ]
]);
