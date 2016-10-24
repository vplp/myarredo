<?php

namespace frontend\modules\shop\widgets\cart;

use thread\app\base\widgets\Widget;

use frontend\modules\shop\models\Cart as CartModel;

/**
 * Class Cart
 *
 * @package frontend\modules\shop\models\Cart
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2014, Thread
 *
 * <?= Cart::widget(); ?>
 *
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
        if (($this->view == 'full' && empty($this->items)) || empty($this->cart)) {
            return false;
        }
        return $this->render($this->view, [
            'cart' => $this->cart,
            'items' => $this->items,
        ]);

    }

}
