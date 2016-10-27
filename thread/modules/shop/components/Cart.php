<?php

namespace thread\modules\shop\components;

use Yii;
use yii\base\{
    Component, ErrorException
};
use yii\log\Logger;
use thread\modules\shop\interfaces\Product as iProduct;
use thread\modules\shop\models\{
    Cart as CartModel, CartItem
};



/**
 * Class Cart
 *
 * @package thread\modules\shop\components
 * @author Alla Kuzmenko
 * @copyright (c), Thread
 */
class Cart extends Component
{
    public $productClass = null;
    public $cart = null;
    public $items = [];
    public $discountCartClass = DiscountCart::class;
    public $discountCartItemClass = DiscountCartItem::class;

    /**
     * @throws ErrorException
     */
    public function init()
    {
        parent::init();

        $product = new $this->productClass;
        if (!($product instanceof iProduct)) {
            throw new ErrorException($this->productClass . ' must be implemented ' . iProduct::class);
        }
        $this->cart = CartModel::findBySessionID();
        $this->items = $this->cart ? $this->cart->items : [];
    }

    /**
     * @param $product_id
     * @return bool|int|string
     */
    public function findProductInItems($product_id)
    {
        if (empty($this->items) === []) {
            return false;
        }
        foreach ($this->items as $key => $item) {
            return ($item['product_id'] == $product_id) ? $key : false;
        }
    }

    /**
     * @return Cart
     */
    public function newCart()
    {
        $this->cart = new CartModel([
            'phpsessid' => CartModel::getSessionID(),
            'user_id' => Yii::$app->getUser()->getId(),
            'scenario' => 'addcart',
        ]);

        return $this->saveCart();
    }

    /**
     * @param int $product_id
     * @param int $count
     * @param array $extra_param
     * @return bool
     * @throws ErrorException
     */
    public function addItem(int $product_id, int $count = 1, array $extra_param):bool
    {
        if (empty($this->cart) && $this->newCart()) {
            throw new ErrorException('Cart can not create!');
        }
        $product = call_user_func([$this->productClass, 'findByID'], $product_id);
//        $product = new $this->productClass;
//        $product = $product::findByID($product_id);

        if (empty($this->product)) {
            throw new ErrorException('Can not find this product!');
        }

        $cartItemKey = $this->findProductInItems($product->id);
        //если товар уже в корзине увеличуем его количество
        if ($cartItemKey !== false) {
            $this->items[$cartItemKey]->count += $count;
        } else {
            $cartItemKey = count($this->items);
            $this->items[$cartItemKey] = new CartItem([
                'cart_id' => $this->cart->id,
                'product_id' => $product->id,
                'price' => $product->getPrice(),
                'count' => $count,
                'extra_param' => $extra_param,
                'scenario' => 'addcartitem',
            ]);
        }

        $this->recalculate($cartItemKey);

        return $this->saveCart($cartItemKey);


    }

    /**
     * @param int $product_id
     * @param int $count
     * @return bool
     * @throws ErrorException
     */
    public function deleteItem(int $product_id, int $count = 0):bool
    {
        $cartItemKey = $this->findProductInItems($product_id);
        if ($cartItemKey !== false) {
            if ($this->items[$cartItemKey]->count > $count && $count != 0) {
                $this->items[$cartItemKey]->count -= $count;
                $this->recalculate($cartItemKey);
            } elseif ($this->items[$cartItemKey]->count == $count || $count == 0) {
                $this->deleteFromCart($cartItemKey);
                $this->recalculate();
                //удаляем индекс товара который удалили
                $cartItemKey = false;
            }
            return $this->saveCart($cartItemKey);

        } else {
            return false;
        }
    }

    /**
     * @return bool
     */
    public function clearCart():bool
    {
        $r = true;
        $transaction = CartModel::getDb()->beginTransaction();
        try {
            if ($this->cart !== null) {
                $r = ($this->cart->delete()) ? $transaction->commit() : $transaction->rollBack();
            }

        } catch (Exception $e) {
            Yii::getLogger()->log($e->getMessage(), Logger::LEVEL_ERROR);
            $r = false;
            $transaction->rollBack();
        }

        return $r;

    }

    /**
     * @param bool $cartItemKey
     */
    public function recalculate($cartItemKey = false)
    {
        if ($cartItemKey !== false) {
            //посчитаем скидку на товар
            (new $this->discountCartItemClass)->calculate($this->items[$cartItemKey]);
            //пересчитаем сумму
            $this->items[$cartItemKey]->recalculate();
        }

        //посчитаем скидку на весь заказ
        $this->cart = (new $this->discountCartClass)->calculate($this->cart);
        //пересчитаем сумму
        $this->cart->recalculate();
    }

    /**
     * @param bool $cartItemKey
     * @return bool
     */
    protected function saveCart($cartItemKey = false)
    {
        $r = true;
        $transaction = CartModel::getDb()->beginTransaction();
        try {
            if ($cartItemKey !== false) {
                $this->items[$cartItemKey]->save();
            }

            $r = ($this->cart->save()) ? $transaction->commit() : $transaction->rollBack();
        } catch (Exception $e) {
            Yii::getLogger()->log($e->getMessage(), Logger::LEVEL_ERROR);
            $r = false;
            $transaction->rollBack();
        }

        return $r;
    }

    /**
     * @param bool $cartItemKey
     * @return bool
     */
    protected function deleteFromCart($cartItemKey)
    {
        $r = true;
        $transaction = CartModel::getDb()->beginTransaction();
        try {
            if ($cartItemKey !== false) {
                $r = ($this->items[$cartItemKey]->delete()) ? $transaction->commit() : $transaction->rollBack();
            }

        } catch (Exception $e) {
            Yii::getLogger()->log($e->getMessage(), Logger::LEVEL_ERROR);
            $r = false;
            $transaction->rollBack();
        }

        return $r;
    }


}
