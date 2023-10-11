<?php

namespace common\modules\shop\components;

use yii\base\Component;
use thread\modules\shop\interfaces\{
    DiscountCartItem as iDiscountCartItem
};
use thread\modules\shop\models\CartItem;

/**
 * Class DiscountCartItem
 *
 * @package common\modules\shop\components
 */
class DiscountCartItem extends Component implements iDiscountCartItem
{
    /**
     * @param CartItem $cartItem
     * @return CartItem
     */
    public function calculate(CartItem $cartItem)
    {
        if ($cartItem->count >= 5){
            $cartItem->discount_percent = 0;
            $cartItem->discount_money = 0;
            $cartItem->discount_full = $cartItem->price * $cartItem->discount_percent + $cartItem->discount_money;
        }

        return $cartItem;
    }
}