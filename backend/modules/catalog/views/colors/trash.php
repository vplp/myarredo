<?php

use yii\helpers\Html;
//
use backend\widgets\GridView\GridView;
//
use thread\widgets\grid\{
    ActionDeleteColumn, ActionRestoreColumn
};

/**
 * @var \backend\modules\catalog\models\Colors $model
 */

echo GridView::widget([
    'dataProvider' => $model->trash(Yii::$app->request->queryParams),
    'filterModel' => $filter,
    'columns' => [
        'alias',
        [
            'attribute' => 'color_code',
            'value' => function ($model) {
                /** @var \backend\modules\catalog\models\Colors $model */
                return Html::tag(
                    'span',
                    '&nbsp;&nbsp;&nbsp;',
                    ['style' => 'background-color: ' . $model->color_code]
                );
            },
            'format' => 'raw',
        ],
        [
            'attribute' => 'title',
            'value' => function ($model) {
                return $model->getTitle();
            },
        ],
        [
            'class' => ActionDeleteColumn::class,
        ],
        [
            'class' => ActionRestoreColumn::class
        ],
    ]
]);
