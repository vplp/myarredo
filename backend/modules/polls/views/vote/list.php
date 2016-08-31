<?php
use yii\helpers\{
    Url
};
use yii\grid\GridView;
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
            'number_of_votes',
            'position',
            [
                'class' => ActionCheckboxColumn::class,
                'attribute' => 'published',
                'action' => 'published'
            ],
            [
                'class' => ActionEditColumn::class,
                'link' => function ($model) {
                    return Url::toRoute([
                        'update',
                        'group_id' => $model['group_id'],
                        'id' => $model['id']
                    ]);
                }
            ],
            [
                'class' => ActionToTrashColumn::class,
                'link' => function ($model) {
                    return Url::toRoute([
                        'intrash',
                        'group_id' => $model['group_id'],
                        'id' => $model['id']
                    ]);
                }
            ],
        ]
    ]
);
