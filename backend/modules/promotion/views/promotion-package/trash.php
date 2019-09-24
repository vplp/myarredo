<?php

use yii\grid\GridView;
//
use backend\modules\promotion\models\PromotionPackage;
use backend\modules\promotion\models\search\PromotionPackage as SearchPromotionPackage;
//
use thread\widgets\grid\{
    ActionDeleteColumn, ActionRestoreColumn
};

/**
 * @var PromotionPackage $model
 * @var SearchPromotionPackage $filter
 */

echo GridView::widget([
    'dataProvider' => $model->trash(Yii::$app->request->queryParams),
    'filterModel' => $filter,
    'columns' => [
        [
            'attribute' => 'title',
            'value' => 'lang.title',
            'label' => Yii::t('app', 'Title'),
        ],
        [
            'class' => ActionDeleteColumn::class,
        ],
        [
            'class' => ActionRestoreColumn::class
        ],
    ]
]);
