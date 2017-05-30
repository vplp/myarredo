<?php
use yii\helpers\{
    Url
};
use backend\widgets\GridView\GridView;
//
use thread\widgets\grid\{
    ActionStatusColumn
};
//
use backend\modules\menu\models\search\MenuItem;

/**
 * @var \backend\modules\menu\models\search\MenuItem $model
 */
echo GridView::widget(
    [
        'dataProvider' => $model->search(Yii::$app->request->queryParams),
        'filterModel' => $filter,
        'useSortable' => true,
        'columns' => [
            [
                'attribute' => 'title',
                'value' => 'lang.title',
                'label' => Yii::t('app', 'Title'),
            ],
            [
                'attribute' => 'link_type',
                'value' => function ($model) {
                    return MenuItem::linkTypeRange()[$model['link_type']];
                },
            ],
            [
                'class' => ActionStatusColumn::class,
                'attribute' => 'published',
                'action' => 'published'
            ],
            [
                'class' => \backend\widgets\GridView\gridColumns\ActionColumn::class,
                'updateLink' => function ($model) {
                    return Url::toRoute([
                        'update',
                        'group_id' => $model['group_id'],
                        'id' => $model['id']
                    ]);
                },
                'deleteLink' => function ($model) {
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
