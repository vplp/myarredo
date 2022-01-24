<?php

use yii\helpers\Html;
use backend\widgets\GridView\GridView;
use backend\modules\catalog\models\{
    Factory, Category
};
use backend\widgets\GridView\gridColumns\ActionColumn;
use thread\widgets\grid\{
    ActionStatusColumn, GridViewFilter
};

$params = Yii::$app->request->queryParams ?? [];

/**
 * @var $model Factory
 */
echo GridView::widget([
    'dataProvider' => $model->searchTranslation($params),
    'filterModel' => $filter,
    'columns' => [
        'id',
        [
            'attribute' => 'title',
            'value' => 'title',
            'label' => Yii::t('app', 'Title'),
        ],
        [
            'attribute' => 'updated_at',
            'value' => function ($model) {
                /** @var $model Factory */
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
