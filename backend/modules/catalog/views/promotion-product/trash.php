<?php

use backend\app\bootstrap\ActiveForm;
use backend\widgets\GridView\GridView;
use thread\widgets\grid\{
    ActionDeleteColumn, ActionRestoreColumn
};
use backend\modules\catalog\models\{
    Factory, FactoryPromotion, Sale
};
use thread\widgets\grid\{
    GridViewFilter
};

/**
 * @var FactoryPromotion $model
 * @var ActiveForm $form
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
                /** @var FactoryPromotion $model */
                return date('j.m.Y', $model->updated_at);
            }
        ],
        [
            'attribute' => Yii::t('app', 'Factory'),
            'value' => function ($model) {
                /** @var Sale $model */
                return ($model['factory']) ? $model['factory']['title'] : '';
            },
            'filter' => GridViewFilter::selectOne($filter, 'factory_id', Factory::dropDownList()),
        ],
        [
            'format' => 'raw',
            'label' => Yii::t('app', 'Список товаров'),
            'value' => function ($model) {
                /** @var FactoryPromotion $model */
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
                /** @var FactoryPromotion $model */
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
                /** @var FactoryPromotion $model */
                return $model->getPaymentStatusTitle();
            },
            'filter' => GridViewFilter::selectOne(
                $filter,
                'payment_status',
                $model::paymentStatusRange()
            ),
        ],
        [
            'attribute' => 'status',
            'value' => function ($model) {
                /** @var FactoryPromotion $model */
                return $model->getStatusTitle();
            },
            'filter' => GridViewFilter::selectOne(
                $filter,
                'status',
                FactoryPromotion::statusRange()
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
