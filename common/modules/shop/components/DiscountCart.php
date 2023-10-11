<?php

namespace common\modules\shop\components;

use yii\base\Component;
use thread\modules\shop\models\Cart;
use thread\modules\shop\interfaces\DiscountCart as iDiscountCart;

/**
 * Class DiscountCart
 *
 * @package common\modules\shop\components
 */
class DiscountCart extends Component implements iDiscountCart
{
    /**
     * @param Cart $cart
     * @return Cart
     */
    public function calculate(Cart $cart)
    {
        $cart->discount_percent = 0;
        $cart->discount_money = 0;
        $cart->discount_full = $cart->items_total_summ * $cart->discount_percent + $cart->discount_money;

        return $cart;
    }
}