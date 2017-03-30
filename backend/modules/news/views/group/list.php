<?php

use yii\helpers\Html;
use backend\widgets\GridView\GridView;
//
use thread\widgets\grid\{
    ActionStatusColumn
};

echo GridView::widget([
    'dataProvider' => $model->search(Yii::$app->request->queryParams),
    'filterModel' => $filter,
    'columns' => [
        [
            'attribute' => 'title',
            'value' => 'lang.title',
        ],
        [
            'label' => Yii::t('news', 'Articles'),
            'format' => 'raw',
            'value' => function ($model) {
                return Html::a(Yii::t('news', 'Articles') . ' (' . $model->getArticlesCount() . ')',
                    ['/news/article/list', 'Article[group_id]' => $model['id']]);
            }
        ],
        [
            'class' => ActionStatusColumn::class,
            'attribute' => 'published',
            'action' => 'published'
        ],
        [
            'class' => \backend\widgets\GridView\gridColumns\ActionColumn::class
        ],
    ]
]);
