<?php

use backend\widgets\GridView\GridView;
//
use thread\widgets\grid\{
    ActionCheckboxColumn, GridViewFilter
};
//
use backend\modules\location\models\Country;

/**
 * @var \backend\modules\location\models\Region $model
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
                return $model->getTitle();
            }
        ],
        [
            'attribute' => 'country_id',
            'value' => 'country.lang.title',
            'label' => Yii::t('app', 'Country'),
            'filter' => GridViewFilter::selectOne($filter, 'country_id', Country::dropDownList())
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
