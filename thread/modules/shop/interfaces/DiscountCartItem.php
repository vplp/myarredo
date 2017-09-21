<?php

namespace thread\modules\shop\interfaces;

use thread\modules\shop\models\CartItem;

/**
 * Interface DiscountCartItem
 *
 * @package thread\modules\shop\interfaces
 */
interface DiscountCartItem
{
    /**
     * @param CartItem $cartItem
     * @return mixed
     */
    public function calculate(CartItem $cartItem);
}