<?php

use backend\widgets\GridView\GridView;
use backend\modules\catalog\models\{
    Category, Factory
};
use backend\modules\location\models\{
    City
};
use backend\modules\user\models\User;
//
use thread\widgets\grid\{
    ActionStatusColumn, GridViewFilter
};

/** @var $model \backend\modules\catalog\models\Sale */

echo GridView::widget([
    'dataProvider' => $model->search(Yii::$app->request->queryParams),
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
                /** @var $model \backend\modules\catalog\models\Sale */
                return ($model['factory']) ? $model['factory']['title'] : $model['factory_name'];
            },
            'filter' => GridViewFilter::selectOne($filter, 'factory_id', Factory::dropDownList()),
        ],
        [
            'value' => function ($model) {
                return ($model->user) ? $model->user->profile->lang->name_company : '';
            },
            'filter' => GridViewFilter::selectOne(
                $filter,
                'user_id',
                User::dropDownListPartner()
            ),
        ],
        [
            'value' => function ($model) {
                return ($model->city) ? $model->city->lang->title : '-';
            },
            'label' => Yii::t('app', 'City'),
            'filter' => GridViewFilter::selectOne($filter, 'city_id', City::dropDownList()),
        ],
        [
            'class' => ActionStatusColumn::class,
            'attribute' => 'published',
            'action' => 'published'
        ],
        [
            'class' => ActionStatusColumn::class,
            'attribute' => 'on_main',
            'action' => 'on_main'
        ],
        [
            'label' => 'Просмотры товара',
            'format' => 'raw',
            'value' => function ($model) {
                /** @var $model \backend\modules\catalog\models\Sale */
                return $model->getCountViews();
            },
        ],
        [
            'label' => 'Запрос телефона',
            'value' => function ($model) {
                /** @var $model \backend\modules\catalog\models\Sale */
                return $model->getCountRequestPhone();
            },
        ],
        [
            'attribute' => 'created_at',
            'value' => function ($model) {
                return date('d.m.Y H:i', $model['created_at']);
            }
        ],
        [
            'attribute' => 'updated_at',
            'value' => function ($model) {
                return date('d.m.Y H:i', $model['updated_at']);
            }
        ],
        [
            'class' => \backend\widgets\GridView\gridColumns\ActionColumn::class
        ],
    ]
]);
