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
    'dataProvider' => $model->searchTranslation($params),
    'filterModel' => $filter,
    'columns' => [
        'id',
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
            'class' => ActionColumn::class,
            'deleteLink' => false
        ],
    ]
]);
