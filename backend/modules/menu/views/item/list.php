<?php
use yii\helpers\Html;
use backend\themes\inspinia\widgets\GridView;

/**
 * @var \backend\modules\menu\models\search\MenuItem $model
 */
echo GridView::widget(
    [
        'dataProvider' => $model->search(Yii::$app->request->queryParams),
        'title' => Yii::t('app', 'Menu') . ' ' . $this->context->group->lang->title,
        'columns' => [
            'lang.title',
            [
                'format' => 'raw',
                'headerOptions' => ['class' => 'text-center col-sm-2'],
                'contentOptions' => ['class' => 'text-center col-sm-2'],
                'value' => function ($model) {
                    return Html::a(
                        'Подкатегории: ' . ' (' . count($model['items']) . ')',
                        [
                            'list', 'group_id' => $model->group_id, 'parent_id' => $model->id
                        ]
                    );
                },
                'visible' => (Yii::$app->request->get('parent_id')) ? false : true,
            ],
            [
                'attribute' => 'link',
                'format' => 'raw',
                'value' => function ($model) {
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
                    return \yii\helpers\Url::toRoute(['update', 'group_id' => Yii::$app->getRequest()->get('group_id'), 'id' => $model->id]);
                },
                'deleteLink' => function ($model) {
                    return \yii\helpers\Url::toRoute(['intrash', 'group_id' => Yii::$app->getRequest()->get('group_id'), 'id' => $model->id]);
                }
            ],
        ]
    ]
);
