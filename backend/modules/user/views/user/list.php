<?php

use yii\helpers\Html;
use backend\widgets\GridView\GridView;
use backend\modules\user\models\Group;
use backend\modules\user\models\User;
use backend\modules\location\models\{
    Country, City
};
use backend\modules\catalog\models\Factory;
use thread\widgets\grid\{
    ActionCheckboxColumn, GridViewFilter
};

$country_id = 0;

$getUser = Yii::$app->getRequest()->get('User');

if (isset($getUser['country_id'])) {
    $country_id = $getUser['country_id'];
}

/**
 * @var $model User
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
        [
            'format' => 'raw',
            'attribute' => 'factory',
            'label' => Yii::t('app', 'Factory'),
            'value' => function ($model) {
                return $model->profile->factory ? $model->profile->factory->title : '';
            },
            'filter' => GridViewFilter::selectOne($filter, 'factory_id', Factory::dropDownList()),
            'visible' => $filter->group_id == 3 ? '1' : '0'
        ],
        'email',
        [
            'format' => 'raw',
            'value' => function ($model) {
                $str = $model->profile->partner_in_city
                    ? '<br><span style="font-size: 80%;">(' . Yii::t('app', 'Главный партнер') . ')</span>'
                    : '';
                return $model->profile->getFullName() . $str;
            },
        ],
        [
            'format' => 'raw',
            'label' => 'Количество авторизаций',
            'value' => function ($model) {
                return $model->getCountLogin();
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
            'format' => 'raw',
            'value' => function ($model) {
                if (isset($model->profile)) {
                    return Html::a('<i class="fa fa-user-md"></i>', ['/user/profile/update', 'id' => $model->profile->id], [
                        'class' => 'btn btn-info'
                    ]);
                } else {
                    return '';
                }
            },
        ],
        [
            'format' => 'raw',
            'value' => function ($model) {
                return Html::a('<i class="fa fa-credit-card"></i>', ['/user/password/change', 'id' => $model->id], [
                    'class' => 'btn btn-warning'
                ]);
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
