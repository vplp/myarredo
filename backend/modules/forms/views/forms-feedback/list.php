<?php

use backend\widgets\GridView;
use backend\widgets\gridColumns\ActionColumn;
use backend\modules\forms\models\FormsFeedback;

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
        'name',
        'phone',
        'email',
        'comment',
        [
            'class' => ActionColumn::class
        ],
    ]
]);
