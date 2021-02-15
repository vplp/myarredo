<?php

use backend\widgets\GridView;
use backend\modules\catalog\models\{
    Category, Factory
};
use backend\modules\location\models\City;
use thread\widgets\grid\{
    ActionCheckboxColumn, GridViewFilter
};

/**
 * @var \backend\modules\articles\models\search\Article $model
 */

echo GridView::widget([
    'dataProvider' => $model->search(Yii::$app->request->queryParams),
    'filterModel' => $filter,
    'columns' => [
        [
            'attribute' => 'city_id',
            'value' => 'city.lang.title',
            'filter' => GridViewFilter::dropDownList(
                $filter,
                'city_id',
                City::dropDownList()
            ),
        ],
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
            'attribute' => 'factory_id',
            'value' => 'factory.title',
            'filter' => GridViewFilter::dropDownList(
                $filter,
                'factory_id',
                Factory::dropDownList()
            ),
        ],
        [
            'attribute' => 'title',
            'value' => 'lang.title',
            'label' => Yii::t('app', 'Title'),
        ],
        [
            'attribute' => 'published_time',
            'filter' => GridViewFilter::datePickerRange($filter, 'date_from', 'date_to'),
            'value' => function ($model) {
                return $model->getPublishedTime();
            },
        ],
        [
            'class' => ActionCheckboxColumn::class,
            'attribute' => 'published',
            'action' => 'published'
        ],
        [
            'class' => \backend\widgets\gridColumns\ActionColumn::class
        ],
    ]
]);
