<?php

namespace frontend\modules\shop\widgets\cart;

use Yii;
use thread\app\base\widgets\Widget;


/**
 * Class Cart
 *
 * @package frontend\modules\shop\models\Cart
 * @author Alla Kuzmenko
 * @copyright (c) 2016, Thread
 *
 * <?= Cart::widget(['view' =>'short']); ?>
 * view/full_popup - popup window with cart(with items)
 * view/full - window cart with items
 * view/short - window cart without items
 */
class Cart extends Widget
{
    public $view = 'short';

    /**
     * @return string
     */
    public function run()
    {
        if (Yii::$app->shop_cart->items) {
            return $this->render($this->view, [
                'cart' => Yii::$app->shop_cart->cart,
                'items' => Yii::$app->shop_cart->items,
            ]);
        } else {
            //если в корзине нет товаров
            return $this->render($this->view . '_empty');
        }


    }

}
