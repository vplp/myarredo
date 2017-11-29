<?php

namespace frontend\modules\shop\models;

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
}