<?php
use yii\helpers\{
    Html, Url
};
//
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
                'format' => 'raw',
                'headerOptions' => ['class' => 'text-center col-sm-2'],
                'contentOptions' => ['class' => 'text-center col-sm-2'],
                'value' => function ($model) {
                    return Html::a(
                        'Подкатегории: ' . ' (' . count($model['items']) . ')',
                        [
                            'list',
                            'group_id' => $model->group_id,
                            'parent_id' => $model->id
                        ]
                    );
                },
                'visible' => (Yii::$app->getRequest()->get('parent_id')) ? false : true,
            ],
            [
                'attribute' => 'link',
                'format' => 'raw',
                'value' => function ($model) {
                    //TODO: Здесь должен быть метод из модели данных
                    return ($model->link_type == 'internal') ? $model->link : $model->link;
                }
            ],
            'position',
            [
                'class' => \thread\widgets\grid\ActionCheckboxColumn::class,
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
