<?php

namespace thread\modules\shop\interfaces;

use thread\modules\shop\models\CartItem;


/**
 * interface DiscountCartItem
 *
 * @package frontend\modules\shop\interfaces
 * @author Alla Kuzmenko
 * @copyright (c), Thread
 */
interface DiscountCartItem
{
    /**
     * @param CartItem $cartItem
     * @return mixed
     */
    public function calculate(CartItem $cartItem);




}