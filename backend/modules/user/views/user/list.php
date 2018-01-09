<?php

use backend\widgets\GridView\GridView;
//
use backend\modules\user\models\Group;
use backend\modules\location\models\{
    Country, City
};
//
use thread\widgets\grid\{
    ActionCheckboxColumn, GridViewFilter
};

$country_id = 0;

$getUser = Yii::$app->getRequest()->get('User');

if(isset($getUser['country_id'])) {
    $country_id = $getUser['country_id'];
}

/**
 * @var $model \backend\modules\user\models\User
 */

echo GridView::widget([
    'dataProvider' => $model->search(Yii::$app->request->queryParams),
    'filterModel' => $filter,
    'columns' => [
        'id',
        [
            'attribute' => 'group_id',
            'value' => 'group.lang.title',
            'filter' => GridViewFilter::selectOne($filter, 'group_id', Group::dropDownList()),
        ],
        'email',
        [
            'value' => function ($model) {
                return $model->profile->getFullName();
            },
        ],
        [
            'value' => function ($model) {
                return $model->profile->getCountryTitle();
            },
            'label' => Yii::t('app', 'Country'),
            'filter' => GridViewFilter::selectOne($filter, 'country_id', Country::dropDownList()),
        ],
        [
            'value' => function ($model) {
                return $model->profile->getCityTitle();
            },
            'label' => Yii::t('app', 'City'),
            'filter' => GridViewFilter::selectOne($filter, 'city_id', City::dropDownList($country_id)),
        ],
        [
            'class' => ActionCheckboxColumn::class,
            'attribute' => 'published',
            'action' => function ($model) {
                return (in_array($model['id'], [1])) ? false : 'published';
            },
        ],
        [
            'class' => \backend\widgets\GridView\gridColumns\ActionColumn::class,
            'deleteLink' => function ($model) {
                return (in_array($model['id'], [1])) ? false : ['intrash', 'id' => $model['id']];
            }
        ],
    ]
]);
