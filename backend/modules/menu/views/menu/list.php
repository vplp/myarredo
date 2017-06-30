<?php
use backend\widgets\GridView\GridView;
use yii\helpers\Html;
//
use thread\widgets\grid\{
    ActionStatusColumn
};

echo GridView::widget(
    [
        'dataProvider' => $model->search(Yii::$app->request->queryParams),
        'filterModel' => $filter,
        'columns' => [
            [
                'class' => \thread\widgets\grid\kartik\EditableColumn::class,
                'attribute' => 'alias',
            ],
            [
                'attribute' => 'title',
                'value' => 'lang.title',
            ],
            [
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a(
                        Yii::t('menu', 'Items') . ': ' . ' (' . $model->getItemsCount() . ')',
                        ['/menu/item/list', 'group_id' => $model['id']]
                    );
                }
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
    ]
);
