<?php

use backend\widgets\GridView;
use backend\widgets\gridColumns\ActionColumn;
use backend\modules\forms\models\Files;

/**
 * @var FormsFeedback $model
 */

echo GridView::widget([
    'dataProvider' => $model->search(Yii::$app->request->queryParams),
    'tableOptions' => ['class' => 'table table-striped table-bordered'],
    'columns' => [
        'name',
        [
            'attribute' => 'url',
            'value' => function ($data) {
                return '/uploads/files/'.$data->url;
            },
        ],
        [
            'class' => ActionColumn::class
        ],
    ]
]);
