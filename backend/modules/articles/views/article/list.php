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
        'id',
        [
            'format' => 'raw',
            'label' => Yii::t('app', 'Cities'),
            'value' => function ($model) {
                /** @var $model Article */
                $result = [];
                foreach ($model->cities as $city) {
                    $result[] = $city->getTitle();
                }
                return ($result) ? implode(' | ', $result) : '-';
            },
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
