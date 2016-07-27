<?php
use thread\widgets\grid\SwitchboxColumn;
use thread\widgets\grid\ActionEditColumn;
use thread\widgets\grid\ActionToTrashColumn;
use backend\themes\inspinia\widgets\GridView;
use yii\bootstrap\Html;

/**
 * @var \backend\modules\page\models\search\Page $model
 */

echo GridView::widget(
    [
        'dataProvider' => $model->search(Yii::$app->request->queryParams),
        'title' => Yii::t('app', 'Menu'),
        'columns' => [
            'lang.title',
            [
                'format' => 'raw',
                'value' => function ($model) {
//                    var_dump($model->items);
                    return Html::a(
                        Yii::t('app', 'Items') . ': ' . ' (' . count($model->items) . ')',
                        ['item/list', 'group_id' => $model->id]
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
