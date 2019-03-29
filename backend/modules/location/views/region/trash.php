<?php

use yii\grid\GridView;
//
use thread\widgets\grid\{
    ActionDeleteColumn, ActionRestoreColumn
};

/**
 * @var \backend\modules\location\models\search\Region $model
 */

echo GridView::widget([
    'dataProvider' => $model->trash(Yii::$app->request->queryParams),
    'filterModel' => $filter,
    'columns' => [
        [
            'label' => Yii::t('app', 'Title'),
            'attribute' => 'title',
            'value' => 'lang.title',
        ],
        [
            'attribute' => 'country_id',
            'value' => 'country.lang.title',
            'label' => Yii::t('app', 'Country'),
        ],
        [
            'class' => ActionDeleteColumn::class,
        ],
        [
            'class' => ActionRestoreColumn::class
        ],
    ]
]);
