<?php
use yii\helpers\Html;
//
use thread\widgets\grid\ActionStatusColumn;
use backend\themes\inspinia\widgets\GridView;

echo GridView::widget(
    [
        'dataProvider' => $model->search(Yii::$app->request->queryParams),
        'filterModel' => $filter,
        'columns' => [
            [
                'attribute' => 'title',
                'value' => 'lang.title',
                'label' => Yii::t('app', 'Title'),
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
                'class' => \backend\themes\inspinia\widgets\gridColumns\ActionColumn::class
            ],
        ]
    ]
);
