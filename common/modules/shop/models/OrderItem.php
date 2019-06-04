<?php

namespace common\modules\shop\models;

use Yii;
use common\modules\catalog\models\Product;
use common\modules\catalog\models\ItalianProduct;

/**
 * Class OrderItem
 *
 * @property Order $order
 * @property Product $product
 * @property OrderItemPrice[] $orderItemPrice
 *
 * @package common\modules\shop\models
 */
class OrderItem extends \thread\modules\shop\models\OrderItem
{
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::class, ['id' => 'order_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        if ($this->order && $this->order->product_type == 'sale-italy') {
            return $this->hasOne(ItalianProduct::class, ['id' => 'product_id']);
        } else {
            return $this->hasOne(Product::class, ['id' => 'product_id']);
        }
    }

    /**
     * @return mixed
     */
    public function getOrderItemPrices()
    {
        return $this->hasMany(OrderItemPrice::class, ['product_id' => 'product_id', 'order_id' => 'order_id']);
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
