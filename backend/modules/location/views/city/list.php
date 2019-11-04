<?php

use backend\widgets\GridView\GridView;
//
use thread\widgets\grid\{
    ActionCheckboxColumn, GridViewFilter
};
//
use backend\modules\location\models\{
    Country, City
};

/**
 * @var City $model
 */

echo GridView::widget([
    'dataProvider' => $model->search(Yii::$app->request->queryParams),
    'filterModel' => $filter,
    'columns' => [
        [
            'class' => \thread\widgets\grid\kartik\EditableColumn::class,
            'label' => Yii::t('app', 'Title'),
            'attribute' => 'title',
            'displayValue' => function ($model) {
                return $model['lang']['title'];
            }
        ],
        [
            'attribute' => 'country_id',
            'value' => 'country.lang.title',
            'label' => Yii::t('app', 'Country'),
            'filter' => GridViewFilter::selectOne($filter, 'country_id', Country::dropDownList())
        ],
        'position',
        [
            'class' => ActionCheckboxColumn::class,
            'attribute' => 'show_price',
            'action' => 'show_price'
        ],
        [
            'class' => ActionCheckboxColumn::class,
            'attribute' => 'published',
            'action' => 'published'
        ],
        [
            'class' => \backend\widgets\GridView\gridColumns\ActionColumn::class
        ],
    ]
]);
