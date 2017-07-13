<?php

namespace thread\modules\shop\interfaces;

use thread\modules\shop\models\Cart;

/**
 * interface DiscountCart
 *
 * @package frontend\modules\shop\interfaces
 * @author Alla Kuzmenko
 * @copyright (c), Thread
 */
interface DiscountCart
{
    /**
     * @param Cart $cart
     * @return mixed
     */
    public function  calculate(Cart $cart);


}