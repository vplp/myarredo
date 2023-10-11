<?php

namespace frontend\modules\shop\models;

use frontend\modules\catalog\models\ItalianProduct;
use frontend\modules\catalog\models\Product;
use Yii;

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
     * @return int
     */
    public function getDeliveryAmountForItalianProduct()
    {
        $volume = $this->product->volume ? $this->product->volume : 2;
        $amount = $this->orderItemPrice->price + $volume * 50;

        $amount = number_format($amount, 2, '.', '');

        return $amount;
    }

    /**
     * @return mixed
     */
    public static function findBase()
    {
        return self::find()
            ->innerJoinWith(['order', 'product'])
            ->orderBy(['created_at' => SORT_DESC]);
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function findById($id)
    {
        return self::findBase()->byID($id)->one();
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

    public function getItalianProduct()
    {
        return $this->hasOne(ItalianProduct::class, ['id' => 'product_id']);
    }

    public function getProductUrl()
    {
        if ($this->order && $this->order->product_type == 'sale-italy') {
            return ItalianProduct::class;
        } else {
            return Product::class;
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
     * @param $params
     * @return \yii\data\ActiveDataProvider
     * @throws \Throwable
     */
    public function search($params)
    {
        return (new search\OrderItem())->search($params);
    }
}
