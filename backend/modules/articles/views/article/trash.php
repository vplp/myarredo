<?php

use yii\grid\GridView;
//
use backend\modules\catalog\models\Category;
//
use thread\widgets\grid\{
    ActionDeleteColumn, ActionRestoreColumn, GridViewFilter
};

/**
 * @var \backend\modules\articles\models\search\Article $model
 */

echo GridView::widget([
    'dataProvider' => $model->trash(Yii::$app->request->queryParams),
    'filterModel' => $filter,
    'columns' => [
        [
            'attribute' => 'category_id',
            'value' => 'category.lang.title',
            'filter' => GridViewFilter::dropDownList(
                $filter,
                'category_id',
                Category::dropDownList()
            ),
        ],
        [
            'attribute' => 'title',
            'value' => 'lang.title',
            'label' => Yii::t('app', 'Title'),
        ],
        [
            'attribute' => 'published_time',
            'value' => function ($model) {
                return $model->getPublishedTime();
            },
        ],
        [
            'class' => ActionDeleteColumn::class,
        ],
        [
            'class' => ActionRestoreColumn::class
        ],
    ]
]);
