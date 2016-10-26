<?php

namespace thread\modules\shop\components;


use Yii;
use yii\base\Component;
use thread\modules\shop\models\Cart;
use thread\modules\shop\interfaces\DiscountCart as iDiscountCart;

//


/**
 * Class DiscountCart
 *
 * @package thread\modules\shop\components
 * @author Alla Kuzmenko
 * @copyright (c), Thread
 */
class DiscountCart extends Component implements iDiscountCart
{
    /**
     * @param Cart $cart
     * @return mixedb
     */
    public function calculate(Cart $cart)
    {
        //на все - 300       
        $cart->discount_percent = 0;
        $cart->discount_money = 300;
        $cart->discount_full = $cart->items_total_summ * $cart->discount_percent + $cart->discount_money;

        return $cart;
    }

}