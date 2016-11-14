<?php
use yii\helpers\Html;
use thread\widgets\grid\{
    GridViewFilter, ActionStatusColumn
};
//
use backend\themes\inspinia\widgets\GridView;

echo GridView::widget([
    'dataProvider' => $model->search(Yii::$app->request->queryParams),
    'filterModel' => $filter,
    'columns' => [
        [
            'attribute' => 'type',
            'filter' => GridViewFilter::dropDownList($filter, 'type', $filter::getTypeRange()),
            'format' => 'raw',
            'value' => function ($model) {
                return Html::tag('span', Yii::t('growl', $model['type']), [
                    'class' => 'label label-' . $model['type']
                ]);
            }
        ],
        'model',
        'message',
        [
            'class' => ActionStatusColumn::class,
            'statusLabel' => [
                0 => 'Unread',
                1 => 'Read',
            ],
            'attribute' => 'is_read',
            'action' => 'is_read'
        ],
        [
            'class' => \backend\themes\inspinia\widgets\gridColumns\ActionColumn::class,
        ],
    ]
]);
