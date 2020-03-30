<?php

use backend\widgets\GridView\GridView;
use backend\modules\catalog\models\CountriesFurniture;
//
use thread\widgets\grid\{
    ActionStatusColumn, GridViewFilter
};
use backend\modules\location\models\Country;
use kartik\widgets\Select2;

/**
 * @var $model CountriesFurniture
 */
echo GridView::widget([
    'dataProvider' => $model->search(Yii::$app->request->queryParams),
    'filterModel' => $model,
    'columns' => [
        'id',
//        [
//            //'attribute' => 'image_link',
//            'value' => function ($model) {
//                return isset($model['price_new']) ? 'ItalianProduct' : 'Product';
//            },
//            //'label' => Yii::t('app', 'Image'),
//            'format' => 'raw',
//            'filter' => false,
//        ],
        [
            //'attribute' => 'title',
            'value' => function ($model) {
                return $model['lang']['title'];
            },
            'label' => Yii::t('app', 'Title'),
            'format' => 'raw',
            'filter' => false
        ],
        [
            'attribute' => 'producing_country_id',
            'value' => function ($model) {
                return $model['factory']['producingCountry']['lang']['title'];
            },
            'filter' => Select2::widget([
                'model' => $model,
                'attribute' => 'producing_country_id',
                'data' => Country::dropDownListForRegistration(),
                'options' => [
                    'placeholder' => Yii::t('app', 'Choose'),
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])
        ],
        [
            'attribute' => 'category',
            'value' => function ($model) {
                $result = [];
                foreach ($model['category'] as $category) {
                    $result[] = ($category['lang']) ? $category['lang']['title'] : '(не задано)';
                }
                return implode(', ', $result);
            },
            'label' => Yii::t('app', 'Category'),
        ],
        [
            'attribute' => Yii::t('app', 'Factory'),
            'value' => 'factory.title',
        ],
        [
            'label' => Yii::t('app', 'Update time'),
            'value' => function ($model) {
                /** @var $model Product */
                return date('j.m.Y H:i', $model['updated_at']);
            },
            'format' => 'raw',
            'filter' => false
        ],
    ]
]);
