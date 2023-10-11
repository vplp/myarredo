<?php

use yii\helpers\Html;
use backend\widgets\GridView\GridView;
use backend\modules\catalog\models\{
    Product, Category, Factory
};
use backend\widgets\GridView\gridColumns\ActionColumn;
use thread\widgets\grid\{
    ActionStatusColumn, GridViewFilter
};

$params = Yii::$app->request->queryParams ?? [];

/**
 * @var $model Product
 */
echo GridView::widget([
    'dataProvider' => $model->searchWithoutSpecificationAndDescription($params),
    'filterModel' => $filter,
    'columns' => [
        'id',
        [
            'attribute' => 'image_link',
            'value' => function ($model) {
                /** @var $model Product */
                return Html::img($model->getImageLink(), ['width' => 50]);
            },
            'label' => Yii::t('app', 'Image'),
            'format' => 'raw',
            'filter' => false
        ],
        [
            'attribute' => 'title',
            'value' => 'lang.title',
            'label' => Yii::t('app', 'Title'),
        ],
        [
            'attribute' => 'updated_at',
            'value' => function ($model) {
                /** @var $model Product */
                return date('j.m.Y H:i', $model->updated_at);
            },
            'format' => 'raw',
            'filter' => false
        ],
        [
            'attribute' => 'category',
            'value' => function ($model) {
                /** @var $model Product */
                /** @var $category Category */
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
            'value' => 'factory.title',
            'filter' => GridViewFilter::selectOne($filter, 'factory_id', Factory::dropDownList()),
        ],
        [
            'class' => ActionColumn::class,
            'updateLink' => function ($model) {
                return isset($model['price_new'])
                    ? ['/catalog/sale-italy/update', 'id' => $model['id']]
                    : ['/catalog/product/update', 'id' => $model['id']];
            },
            'deleteLink' => false
        ],
    ]
]);
