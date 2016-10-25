<?php

namespace frontend\modules\shop\widgets\cart;

use thread\app\base\widgets\Widget;

use frontend\modules\shop\models\Cart as CartModel;

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
    private $cart = null;
    private $items = null;

    public function init()
    {
        $this->cart = CartModel::findBySessionID();
        if ($this->view == 'full') {
            $this->items = $this->cart->items;
        }

    }

    public function run()
    {
        
        if (($this->view == 'full' && empty($this->items)) || empty($this->cart) || $this->view == null) {
            return false;
        }
        return $this->render($this->view, [
            'cart' => $this->cart,
            'items' => $this->items,
        ]);

    }

}
