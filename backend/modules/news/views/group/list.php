<?php

use yii\helpers\Html;
use yii\grid\GridView;
//
use thread\widgets\grid\{
    ActionEditColumn, ActionToTrashColumn, ActionCheckboxColumn
};

echo GridView::widget([
    'dataProvider' => $model->search(Yii::$app->request->queryParams),
    'filterModel' => $filter,
    'columns' => [
        [
            'attribute' => 'title',
            'value' => 'lang.title',
            'label' => Yii::t('app', 'Title'),
        ],
        [
            'label' => 'Articles',
            'format' => 'raw',
            'value' => function ($model) {
                return Html::a(Yii::t('app', 'Articles') . ' (' . count($model->articles) . ')',
                    ['/news/article/list', 'Article[group_id]' => $model['id']]);
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
]);
