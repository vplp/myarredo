<?php

use backend\app\bootstrap\ActiveForm;
use backend\widgets\GridView\GridView;
use backend\modules\catalog\models\{
    Factory, FactoryPromotion, Sale
};
use thread\widgets\grid\{
    ActionStatusColumn, GridViewFilter
};

/**
 * @var FactoryPromotion $model
 * @var ActiveForm $form
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
                $products = $model->factory_id ? $model->products : $model->italianProducts;
                foreach ($products as $product) {
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
            'attribute' => 'start_date_promotion',
            'value' => function ($model) {
                /** @var FactoryPromotion $model */
                return $model->payment_status == 'success'
                    ? date('j.m.Y H:i', $model->start_date_promotion)
                    : '-';
            },
            'format' => 'raw',
            'filter' => false
        ],
        [
            'attribute' => 'end_date_promotion',
            'value' => function ($model) {
                /** @var FactoryPromotion $model */
                return $model->payment_status == 'success'
                    ? date('j.m.Y H:i', $model->end_date_promotion)
                    : '-';
            },
            'format' => 'raw',
            'filter' => false
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
            'class' => ActionStatusColumn::class,
            'attribute' => 'published',
            'action' => 'published'
        ],
        [
            'class' => \backend\widgets\GridView\gridColumns\ActionColumn::class
        ],
    ]
]);
