<?php

use backend\widgets\GridView\GridView;
use thread\widgets\grid\{
    ActionStatusColumn, GridViewFilter
};

/**
 * @var \backend\modules\catalog\models\FactoryPromotion $model
 * @var \backend\app\bootstrap\ActiveForm $form
 */

echo GridView::widget([
    'dataProvider' => $model->search(Yii::$app->request->queryParams),
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
                    1 => Yii::t('app', 'Активная')
                ]
            ),
        ],
        [
            'class' => ActionStatusColumn::class,
            'attribute' => 'published',
            'action' => 'published'
        ],
        [
            'class' => \backend\widgets\GridView\gridColumns\ActionColumn::class
        ],
    ]
]);
