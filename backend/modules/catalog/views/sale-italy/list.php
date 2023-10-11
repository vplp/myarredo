<?php

use backend\widgets\GridView\GridView;
use backend\modules\catalog\models\{
    Category, Factory, ItalianProduct
};
use backend\modules\location\models\{
    City
};
use backend\modules\user\models\User;
use thread\widgets\grid\{
    ActionStatusColumn, GridViewFilter
};

/** @var $model ItalianProduct */

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
                /** @var $model ItalianProduct */
                $result = [];
                foreach ($model->category as $category) {
                    /** @var $category Category */
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
                /** @var $model ItalianProduct */
                return ($model['factory']) ? $model['factory']['title'] : $model['factory_name'];
            },
            'filter' => GridViewFilter::selectOne($filter, 'factory_id', Factory::dropDownList()),
        ],
        [
            'value' => function ($model) {
                /** @var $model ItalianProduct */
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
                /** @var $model ItalianProduct */
                return ($model->city) ? $model->city->getTitle() : '-';
            },
            'label' => Yii::t('app', 'City'),
            'filter' => GridViewFilter::selectOne($filter, 'city_id', City::dropDownList()),
        ],
        [
            'attribute' => 'create_mode',
            'value' => function ($model) {
                /** @var $model ItalianProduct */
                return ItalianProduct::createModeRange($model->create_mode);
            },
        ],
        [
            'value' => function ($model) {
                /** @var $model ItalianProduct */
                $status = $model->payment ? Yii::t('app', ucfirst($model->payment->payment_status)) : '-';

                if ($model->payment && $model->payment->payment_status == 'success') {
                    $status .= ' ' . date('Y-m-d', $model->payment->payment_time);
                }

                return $status;
            },
            'label' => Yii::t('app', 'Payment status'),
        ],
        [
            'value' => function ($model) {
                /** @var $model ItalianProduct */
                return $model::statusRange($model->status);
            },
            'label' => Yii::t('app', 'Status'),
        ],
        [
            'label' => Yii::t('app', 'Количество просмотров'),
            'format' => 'raw',
            'value' => function ($model) {
                /** @var $model ItalianProduct */
                return $model->getCountViews();
            },
        ],
        [
            'label' => Yii::t('app', 'Количество запросов'),
            'value' => function ($model) {
                /** @var $model ItalianProduct */
                return $model->getCountRequests();
            },
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
            'class' => ActionStatusColumn::class,
            'attribute' => 'bestseller',
            'action' => 'bestseller'
        ],
        [
            'class' => ActionStatusColumn::class,
            'attribute' => 'is_sold',
            'action' => 'is_sold'
        ],
        [
            'class' => \backend\widgets\GridView\gridColumns\ActionColumn::class
        ],
    ]
]);
