<?php

use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model \backend\modules\shop\models\Order */

echo GridView::widget([
    'dataProvider' => $model->items[0]->search(['OrderItem' => ['order_id' => $model->id]]),
    'columns' => [
        [
            'attribute' => Yii::t('app', 'Product'),
            'value' => function ($model) {
                //тянем модель продукта которая указана в компоненте shop_cart
                $product = call_user_func([Yii::$app->shop_cart->threadProductClass, 'findByID'], $model->id);
                return $product['id'] . ' ' . $product['lang']['title'];
            }
        ],
    ],
]);
