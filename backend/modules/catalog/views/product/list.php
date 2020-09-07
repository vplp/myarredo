<?php

use yii\helpers\Html;
use backend\widgets\GridView\GridView;
use backend\modules\catalog\models\{
    Product, Category, Factory
};
use thread\widgets\grid\{
    ActionStatusColumn, GridViewFilter
};

/**
 * @var $model Product
 * @var $filter Product
 */

echo GridView::widget([
    'dataProvider' => $model->search(Yii::$app->request->queryParams),
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
            'attribute' => 'created_at',
            'value' => function ($model) {
                /** @var $model Product */
                return date('j.m.Y H:i', $model->created_at);
            },
            'format' => 'raw',
            'filter' => false
        ],
        [
            'attribute' => 'Редактор',
            'value' => 'editor.profile.fullName',
            'filter' => GridViewFilter::selectOne($filter, 'editor_id', [0 => '-'] + Product::dropDownListEditor()),
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
            'class' => ActionStatusColumn::class,
            'attribute' => 'published',
            'action' => 'published'
        ],
        [
            'class' => ActionStatusColumn::class,
            'attribute' => 'novelty',
            'action' => 'novelty'
        ],
        [
            'class' => ActionStatusColumn::class,
            'attribute' => 'removed',
            'action' => 'removed'
        ],
        [
            'class' => \backend\widgets\GridView\gridColumns\ActionColumn::class
        ],
    ]
]);
