<?php

use backend\widgets\GridView\GridView;
//
use backend\modules\catalog\models\{
    Category, Factory
};
//
use thread\widgets\grid\{
    ActionStatusColumn, GridViewFilter
};

/**
 * @var \backend\modules\catalog\models\Product $model
 */

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
            'attribute' => 'category',
            'value' => function ($model) {
                $result = [];
                foreach ($model->category as $category) {
                    $result[] = ($category->lang) ? $category->lang->title : '(не задано)';
                }
                return implode(', ', $result);
            },
            'label' => Yii::t('app', 'Category'),
            'filter' => GridViewFilter::selectOne($filter, 'category', Category::dropDownList()),
        ],
        [
            'attribute' => Yii::t('app', 'Factory'),
            'value' => 'factory.title',
            'filter' => GridViewFilter::selectOne($filter, 'factory_id', Factory::dropDownList()),
        ],
        [
            'class' => ActionStatusColumn::class,
            'attribute' => 'popular',
            'action' => 'popular'
        ],
        [
            'class' => ActionStatusColumn::class,
            'attribute' => 'novelty',
            'action' => 'novelty'
        ],
        [
            'class' => ActionStatusColumn::class,
            'attribute' => 'bestseller',
            'action' => 'bestseller'
        ],
        [
            'class' => ActionStatusColumn::class,
            'attribute' => 'onmain',
            'action' => 'onmain'
        ],
        [
            'class' => ActionStatusColumn::class,
            'attribute' => 'published',
            'action' => 'published'
        ],
        [
            'class' => ActionStatusColumn::class,
            'attribute' => 'removed',
            'action' => 'removed'
        ],
        [
            'class' => \backend\widgets\GridView\gridColumns\ActionColumn::class
        ],
    ]
]);
