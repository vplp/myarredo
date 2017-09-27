<?php

namespace thread\modules\shop\interfaces;

use thread\modules\shop\models\Cart;

/**
 * Interface DiscountCart
 *
 * @package thread\modules\shop\interfaces
 */
interface DiscountCart
{
    /**
     * @param Cart $cart
     * @return mixed
     */
    public function calculate(Cart $cart);
}