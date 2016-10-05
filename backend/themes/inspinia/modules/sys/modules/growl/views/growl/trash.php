<?php
use yii\helpers\Html;
use thread\widgets\grid\{
    ActionDeleteColumn, ActionRestoreColumn
};
//
use backend\themes\inspinia\widgets\GridView;

echo GridView::widget([
    'dataProvider' => $model->trash(Yii::$app->request->queryParams),
    'filterModel' => $filter,
    'columns' => [
        [
            'attribute' => 'type',
            'value' => function ($model) {
                return Html::tag('span', $model['type'], [
                    'class' => 'label label-' . $model['type']
                ]);
            }
        ],
        'model',
        'message',
        [
            'class' => ActionDeleteColumn::class,
        ],
        [
            'class' => ActionRestoreColumn::class,
        ],
    ]
]);
