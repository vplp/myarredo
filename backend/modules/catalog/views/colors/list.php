<?php

use yii\helpers\Html;
//
use backend\widgets\GridView\GridView;
//
use thread\widgets\grid\{
    ActionStatusColumn
};

/**
 * @var \backend\modules\catalog\models\Colors $model
 */

echo GridView::widget([
    'dataProvider' => $model->search(Yii::$app->request->queryParams),
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
            'class' => ActionStatusColumn::class,
            'attribute' => 'published',
            'action' => 'published'
        ],
        [
            'class' => \backend\widgets\GridView\gridColumns\ActionColumn::class
        ],
    ]
]);
