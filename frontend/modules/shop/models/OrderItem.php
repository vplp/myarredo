<?php

namespace frontend\modules\shop\models;

use frontend\modules\catalog\models\Product;

/**
 * Class OrderItem
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
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }
}