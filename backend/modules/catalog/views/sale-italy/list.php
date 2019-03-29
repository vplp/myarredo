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

/** @var $model \backend\modules\catalog\models\ItalianProduct */

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
            'value' => function ($model) {
                /** @var $model \backend\modules\catalog\models\ItalianProduct */

                $status = $model->payment ? Yii::t('app', ucfirst($model->payment->payment_status)) : '';

                if ($model->payment && $model->payment->payment_status == 'success') {
                    $status .= ' ' .  date('Y-m-d', $model->payment->payment_time);
                }

                return $status;
            },
            'label' => Yii::t('app', 'Payment status'),
        ],
        [
            'attribute' => Yii::t('app', 'Factory'),
            'value' => function ($model) {
                /** @var $model \backend\modules\catalog\models\ItalianProduct */
                return ($model['factory']) ? $model['factory']['title'] : $model['factory_name'];
            },
            'filter' => GridViewFilter::selectOne($filter, 'factory_id', Factory::dropDownList()),
        ],
        [
            'value' => function ($model) {
                return ($model->user) ? $model->user->profile->name_company : '';
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
            'class' => \backend\widgets\GridView\gridColumns\ActionColumn::class
        ],
    ]
]);
