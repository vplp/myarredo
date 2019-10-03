<?php


use backend\widgets\GridView\GridView;
use thread\widgets\grid\{
    ActionDeleteColumn, ActionRestoreColumn
};
use backend\modules\catalog\models\{
    Factory
};
//
use thread\widgets\grid\{
    GridViewFilter
};

/**
 * @var \backend\modules\catalog\models\FactoryPromotion $model
 * @var \backend\app\bootstrap\ActiveForm $form
 */

echo GridView::widget([
    'dataProvider' => $model->trash(Yii::$app->request->queryParams),
    'filterModel' => $filter,
    'columns' => [
        'id',
        [
            'format' => 'raw',
            'attribute' => 'updated_at',
            'label' => Yii::t('app', 'Дата'),
            'value' => function ($model) {
                return date('j.m.Y', $model->updated_at);
            }
        ],
        [
            'attribute' => Yii::t('app', 'Factory'),
            'value' => function ($model) {
                /** @var $model \backend\modules\catalog\models\Sale */
                return ($model['factory']) ? $model['factory']['title'] : '';
            },
            'filter' => GridViewFilter::selectOne($filter, 'factory_id', Factory::dropDownList()),
        ],
        [
            'format' => 'raw',
            'label' => Yii::t('app', 'Список товаров'),
            'value' => function ($model) {
                /** @var \backend\modules\catalog\models\FactoryPromotion $model */
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
                /** @var \backend\modules\catalog\models\FactoryPromotion $model */
                return count($model->cities);
            },
        ],
        [
            'attribute' => 'amount',
            'value' => 'amount',
        ],
        [
            'attribute' => 'payment_status',
            'value' => function ($model) {
                /** @var \backend\modules\catalog\models\FactoryPromotion $model */
                return $model->getPaymentStatusTitle();
            },
            'filter' => GridViewFilter::selectOne(
                $filter,
                'payment_status',
                $model::paymentStatusKeyRange()
            ),
        ],
        [
            'attribute' => 'status',
            'value' => function ($model) {
                /** @var \backend\modules\catalog\models\FactoryPromotion $model */
                return $model->getStatusTitle();
            },
            'filter' => GridViewFilter::selectOne(
                $filter,
                'status',
                [
                    0 => Yii::t('app', 'Завершена'),
                    1 => Yii::t('app', 'Не активная')
                ]
            ),
        ],
        [
            'class' => ActionDeleteColumn::class,
        ],
        [
            'class' => ActionRestoreColumn::class
        ],
    ]
]);
