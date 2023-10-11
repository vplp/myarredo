<?php

use kartik\widgets\Select2;
use backend\widgets\GridView\GridView;
use backend\modules\catalog\models\{
    CountriesFurniture, Category, Factory
};
use backend\widgets\GridView\gridColumns\ActionColumn;
use backend\modules\location\models\Country;

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
            'attribute' => 'title',
            'value' => function ($model) {
                return $model['lang']['title'];
            },
            'label' => Yii::t('app', 'Title'),
            'format' => 'raw'
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
            'filter' => Select2::widget([
                'model' => $model,
                'attribute' => 'category',
                'data' => Category::dropDownList(),
                'options' => [
                    'placeholder' => Yii::t('app', 'Choose'),
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])
        ],
        [
            'attribute' => 'factory',
            'value' => 'factory.title',
            'filter' => Select2::widget([
                'model' => $model,
                'attribute' => 'factory',
                'data' => Factory::dropDownList(),
                'options' => [
                    'placeholder' => Yii::t('app', 'Choose'),
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])
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
        [
            'class' => ActionColumn::class,
            'updateLink' => function ($model) {
                return isset($model['price_new'])
                    ? ['/catalog/sale-italy/update', 'id' => $model['id']]
                    : ['/catalog/product/update', 'id' => $model['id']];
            },
            'deleteLink' => function ($model) {
                return isset($model['price_new'])
                    ? ['/catalog/sale-italy/intrash', 'id' => $model['id']]
                    : ['/catalog/product/intrash', 'id' => $model['id']];
            }
        ],
    ]
]);
