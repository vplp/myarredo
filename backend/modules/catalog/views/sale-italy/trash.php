<?php

use backend\widgets\GridView\GridView;
use backend\modules\catalog\models\{
    Category, Factory
};
use backend\modules\location\models\{
    City
};
use backend\modules\user\models\User;
use thread\widgets\grid\{
    ActionDeleteColumn, ActionRestoreColumn, GridViewFilter
};

/** @var $model \backend\modules\catalog\models\ItalianProduct */

echo GridView::widget([
    'dataProvider' => $model->trash(Yii::$app->request->queryParams),
    'filterModel' => $filter,
    'columns' => [
        'id',
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
            'value' => function ($model) {
                /** @var $model \backend\modules\catalog\models\ItalianProduct */
                return ($model['factory']) ? $model['factory']['title'] : $model['factory_name'];
            },
        ],
        [
            'value' => function ($model) {
                return (isset($model->user->profile) && isset($model->user->profile->lang))
                    ? $model->user->profile->lang->name_company
                    : '';
            },
            'filter' => GridViewFilter::selectOne(
                $filter,
                'user_id',
                User::dropDownListPartner()
            ),
        ],
        [
            'value' => function ($model) {
                return ($model->city) ? $model->city->getTitle() : '-';
            },
            'label' => Yii::t('app', 'City'),
            'filter' => GridViewFilter::selectOne($filter, 'city_id', City::dropDownList()),
        ],
        [
            'class' => ActionDeleteColumn::class,
        ],
        [
            'class' => ActionRestoreColumn::class
        ],
    ]
]);
