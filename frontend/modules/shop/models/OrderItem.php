<?php

namespace frontend\modules\shop\models;

use frontend\modules\catalog\models\ItalianProduct;
use frontend\modules\catalog\models\Product;

/**
 * Class OrderItem
 *
 * @property Product $product
 * @property OrderItemPrice[] $orderItemPrice
 *
 * @package frontend\modules\shop\models
 */
class OrderItem extends \common\modules\shop\models\OrderItem
{
    /**
     * @return array
     */
    public function scenarios()
    {
        return [
            'addNewOrderItem' => [
                'order_id',
                'product_id',
                'summ',
                'total_summ',
                'discount_percent',
                'discount_money',
                'discount_full',
                'extra_param',
                'count'],
        ];
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
}
