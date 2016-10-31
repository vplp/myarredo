<?php

namespace thread\modules\shop\components;


use Yii;
use yii\base\Component;
use thread\modules\shop\models\Cart as ModelCart;
use thread\modules\shop\interfaces\DiscountCart as iDiscountCart;

//


/**
 * Class DiscountCart
 *
 * Скидки на весь заказ, например на весь чек минус 20% или 200грн
 * @package thread\modules\shop\components
 * @author Alla Kuzmenko
 * @copyright (c), Thread
 */
class DiscountCart extends Component implements iDiscountCart
{
    /**
     * @param ModelCart $cart
     * @return mixedb
     */
    public function calculate(ModelCart $cart)
    {
        //на все - 300       
        $cart->discount_percent = 0;
        //$cart->discount_money = 300;
        $cart->discount_money = 0;
        $cart->discount_full = $cart->items_total_summ * $cart->discount_percent + $cart->discount_money;

        return $cart;
    }

}