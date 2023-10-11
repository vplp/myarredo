<?php

namespace frontend\modules\shop\widgets\cart;

use Yii;
//
use frontend\modules\catalog\models\ItalianProduct;
//
use thread\app\base\widgets\Widget;

/**
 * Class Cart
 *
 * @package frontend\modules\shop\models\Cart
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
        if (!empty(Yii::$app->shop_cart->items)) {
            $products_id = [];

            foreach (Yii::$app->shop_cart->items as $item) {
                $products_id[] = $item->product_id;
            }


            $products1 = call_user_func([Yii::$app->shop_cart->frontendProductClass, 'findByIDs'], $products_id);

            $products2 = call_user_func([ItalianProduct::class, 'findByIDs'], $products_id);

            $products = array_merge($products1, $products2);
            $products_id = [];

            //заполним массив с продуктами так, чтобы айдишники стали ключами
            foreach ($products as $product) {
                $products_id[$product->id] = $product;
            }
            unset($products);

            return $this->render($this->view, [
                'cart' => Yii::$app->shop_cart->cart,
                'items' => Yii::$app->shop_cart->items,
                'products' => $products_id,
            ]);
        } else {
            //если в корзине нет товаров
            return $this->render($this->view . '_empty');
        }
    }
}