<?php

use thread\widgets\grid\{
    ActionCheckboxColumn, GridViewFilter
};
//
use backend\themes\inspinia\widgets\GridView;
use backend\modules\location\models\Country;

/**
 * @var \backend\modules\location\models\search\City $model
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
            'attribute' => 'location_country_id',
            'value' => 'country.lang.title',
            'filter' => GridViewFilter::dropDownList($filter, 'location_country_id', Country::dropDownList())
        ],
        [
            'class' => ActionCheckboxColumn::class,
            'attribute' => 'published',
            'action' => 'published'
        ],
        [
            'class' => \backend\themes\inspinia\widgets\gridColumns\ActionColumn::class
        ],
    ]
]);
