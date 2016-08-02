<?php
//
use yii\bootstrap\Html;
//
use thread\widgets\grid\SwitchboxColumn;
//
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
                        Yii::t('app', 'Items') . ': ' . ' (' . $model->getItemsCount() . ')',
                        ['item/list', 'group_id' => $model['id']]
                    );
                }
            ],
            [
                'class' => \thread\widgets\grid\ActionCheckboxColumn::class,
                'attribute' => 'published',
                'action' => 'published'
            ],
            [
                'class' => \backend\themes\inspinia\widgets\gridColumns\ActionColumn::class,
            ],
        ]
    ]
);
