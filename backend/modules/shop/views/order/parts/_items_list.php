<?php

use yii\grid\GridView;

/**
 *
 * @package backend\modules\shop\view
 * @author Alla Kuzmenko
 * @copyright (c) 2015, Thread
 *
 */
echo GridView::widget([
    'dataProvider' => $model->items[0]->search(['OrderItem' => ['order_id' => $model->id]]),
    //'filterModel' => $filter,
    'columns' => [
        [
            'attribute' => 'product_id',
            'value' => function ($model) {
                //тянем модель продукта которая указана в компоненте shop_cart
                $product = call_user_func([Yii::$app->shop_cart->threadProductClass, 'findByID'], $model->product_id);
                return $product['id'] . ' ' . $product['Name'];
            }
        ],
        'count',
        'price',
        // 'summ',
        // 'discount_full',
        'total_summ',
        //'discount_percent',
        // 'discount_money',
        //'extra_param',
    ],
]);
