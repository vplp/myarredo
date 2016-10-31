<?php

namespace thread\modules\shop\components;


use Yii;
use yii\base\Component;

use thread\modules\shop\interfaces\{
    DiscountCartItem as iDiscountCartItem
};
use thread\modules\shop\models\CartItem;

//


/**
 * Class DiscountCartItem
 * Скидки на позицию в чеке, например на позицию в которой больше 5 шт - 20 %
 * @package thread\modules\shop\components
 * @author Alla Kuzmenko
 * @copyright (c), Thread
 */
class DiscountCartItem extends Component implements iDiscountCartItem
{
    /**
     * @param CartItem $cartItem
     * @return mixedb
     */
    public function calculate(CartItem $cartItem)
    {
        //на все позиции от 5 шт - 30%
        if ($cartItem->count >= 5){
           // $cartItem->discount_percent = 0.3;
            $cartItem->discount_percent = 0;
            $cartItem->discount_money = 0;
            $cartItem->discount_full = $cartItem->price * $cartItem->discount_percent + $cartItem->discount_money;            
        }
        
        return $cartItem;
    }
    

}