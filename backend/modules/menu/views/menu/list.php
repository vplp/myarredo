<?php
use yii\grid\GridView;
use yii\helpers\Html;
//
use thread\widgets\grid\{
    ActionEditColumn, ActionToTrashColumn, ActionCheckboxColumn
};

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
                        ['/menu/item/list', 'group_id' => $model['id']]
                    );
                }
            ],
            [
                'class' => ActionCheckboxColumn::class,
                'attribute' => 'published',
                'action' => 'published'
            ],
            [
                'class' => ActionEditColumn::class,
            ],
            [
                'class' => ActionToTrashColumn::class
            ],
        ]
    ]
);
