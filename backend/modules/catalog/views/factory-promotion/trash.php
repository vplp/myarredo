<?php


use backend\widgets\GridView\GridView;
use thread\widgets\grid\{
    ActionDeleteColumn, ActionRestoreColumn
};

/**
 * @var \backend\modules\catalog\models\FactoryPromotion $model
 * @var \backend\app\bootstrap\ActiveForm $form
 */

echo GridView::widget([
    'dataProvider' => $model->trash(Yii::$app->request->queryParams),
    'filterModel' => $filter,
    'columns' => [
        [
            'format' => 'raw',
            'attribute' => 'updated_at',
            'label' => Yii::t('app', 'Дата'),
            'value' => function ($model) {
                return date('j.m.Y', $model->updated_at);
            }
        ],
        [
            'format' => 'raw',
            'label' => Yii::t('app', 'Список товаров'),
            'value' => function ($model) {
                /** @var \frontend\modules\catalog\models\FactoryPromotion $model */
                $result = [];
                foreach ($model->products as $product) {
                    $result[] = $product->lang->title;
                }
                return implode(' | ', $result);
            },
        ],
        [
            'format' => 'raw',
            'label' => Yii::t('app', 'Кол-во городов'),
            'value' => function ($model) {
                /** @var \frontend\modules\catalog\models\FactoryPromotion $model */
                return count($model->cities);
            },
        ],
        [
            'attribute' => 'cost',
            'value' => 'cost',
            'label' => Yii::t('app', 'Бюджет'),
        ],
        [
            'class' => ActionDeleteColumn::class,
        ],
        [
            'class' => ActionRestoreColumn::class
        ],
    ]
]);
