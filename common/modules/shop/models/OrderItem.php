<?php

namespace common\modules\shop\models;

use Yii;
use common\modules\catalog\models\Product;

/**
 * Class OrderItem
 *
 * @package common\modules\shop\models
 */
class OrderItem extends \thread\modules\shop\models\OrderItem
{
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }

    /**
     * @return mixed
     */
    public function getOrderItemPrices()
    {
        return $this
            ->hasMany(OrderItemPrice::class, ['product_id' => 'product_id', 'order_id' => 'order_id']);
    }

    /**
     * @return mixed
     */
    public function getOrderItemPrice()
    {
        $modelOrderItemPrice = OrderItemPrice::findByOrderIdUserIdProductId(
            $this->order_id,
            Yii::$app->getUser()->getId(),
            $this->product_id
        );

        if ($modelOrderItemPrice == null) {
            $modelOrderItemPrice = new OrderItemPrice();
        }

        return $modelOrderItemPrice;
    }
}