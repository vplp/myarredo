<?php
use yii\helpers\Url;
use thread\widgets\grid\ActionCheckboxColumn;
use backend\themes\inspinia\widgets\GridView;

/**
 * @var \backend\modules\menu\models\search\MenuItem $model
 */
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
                'attribute' => 'link',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->getLink();
                }
            ],
            'position',
            [
                'class' => ActionCheckboxColumn::class,
                'attribute' => 'published',
                'action' => 'published'
            ],
            [
                'class' => \backend\themes\inspinia\widgets\gridColumns\ActionColumn::class,
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
