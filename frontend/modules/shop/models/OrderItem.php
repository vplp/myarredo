<?php

namespace frontend\modules\shop\models;

use common\modules\shop\models\OrderItem as CommonOrderItemModel;

/**
 * Class OrderItem
 * @package frontend\modules\shop\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @author Alla Kuzmenko
 * @copyright (c) 2016, VipDesign
 */
class OrderItem extends CommonOrderItemModel 
{
    /**
     *
     * @return array
     */
    public function scenarios()
    {
        return [
            'addneworderitem' => [
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