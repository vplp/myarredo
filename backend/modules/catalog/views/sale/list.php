<?php

use backend\widgets\GridView\GridView;

use backend\modules\catalog\models\{
    Category, Factory
};
//
use thread\widgets\grid\{
    ActionStatusColumn, GridViewFilter
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
            'attribute' => 'on_main',
            'action' => 'on_main'
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
