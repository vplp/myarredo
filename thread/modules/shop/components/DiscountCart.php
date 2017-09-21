<?php

namespace thread\modules\shop\components;

use yii\base\Component;
use thread\modules\shop\models\Cart as ModelCart;
use thread\modules\shop\interfaces\DiscountCart as iDiscountCart;

/**
 * Class DiscountCart
 *
 * @package thread\modules\shop\components
 */
class DiscountCart extends Component implements iDiscountCart
{
    /**
     * @param ModelCart $cart
     * @return ModelCart
     */
    public function calculate(ModelCart $cart)
    {
        $cart->discount_percent = 0;
        $cart->discount_money = 0;
        $cart->discount_full = $cart->items_total_summ * $cart->discount_percent + $cart->discount_money;

        return $cart;
    }
}