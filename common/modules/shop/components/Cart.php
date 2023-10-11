<?php

namespace common\modules\shop\components;

use Yii;
use yii\base\{
    Component, ErrorException
};
use yii\log\Logger;
use thread\modules\shop\interfaces\Product as iProductThreadModel;
use common\modules\shop\models\{
    Cart as CartModel, CartItem
};

/**
 * Class Cart
 *
 * @package common\modules\shop\components
 */
class Cart extends Component
{
    public $threadProductClass = null;
    public $frontendProductClass = null;
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

        $product = new $this->threadProductClass();

        if (!($product instanceof iProductThreadModel)) {
            throw new ErrorException($this->threadProductClass . ' must be implemented ' . iProductThreadModel::class);
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
        if ($this->items === []) {
            return false;
        }

        foreach ($this->items as $key => $item) {
            if ($item['product_id'] == $product_id) {
                return $key;
            }
        }

        return false;
    }

    /**
     * @return bool
     */
    public function newCart()
    {
        $this->cart = new CartModel([
            'php_session_id' => CartModel::getSessionID(),
            'user_id' => Yii::$app->getUser()->getId() ?? 0
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
    public function addItem(int $product_id, int $count = 1, array $extra_param): bool
    {
        if (empty($this->cart) && !$this->newCart()) {
            throw new ErrorException('Cart can not create!');
        }
        $product = call_user_func([$this->threadProductClass, 'findByID'], $product_id);

        if (empty($product)) {
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
                'discount_percent' => $product->getDiscount(),
                'count' => $count,
                'extra_param' => implode(', ', $extra_param)
            ]);
        }
        $this->recalculate($cartItemKey);

        return $this->saveCart($cartItemKey);
    }

    /**
     * @param int $product_id
     * @param int $count
     * @return bool
     */
    public function deleteItem(int $product_id, int $count = 0): bool
    {
        $cartItemKey = $this->findProductInItems($product_id);
        if ($cartItemKey !== false) {
            if ($this->items[$cartItemKey]->count > $count && $count != 0) {
                $this->items[$cartItemKey]->count -= $count;
                $this->recalculate($cartItemKey);
            } elseif ($this->items[$cartItemKey]->count == $count || $count == 0) {
                $this->deleteFromCart($cartItemKey);
                unset($this->items[$cartItemKey]);

                //удаляем индекс товара который удалили
                $this->recalculate();
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
    public function clearCart(): bool
    {
        $r = true;
        $transaction = CartModel::getDb()->beginTransaction();
        try {
            if ($this->cart !== null) {
                if ($this->cart->delete()) {
                    $transaction->commit();
                    $r = true;
                } else {
                    $transaction->rollBack();
                    $r = false;
                }
            }
        } catch (Exception $e) {
            Yii::getLogger()->log($e->getMessage(), Logger::LEVEL_ERROR);
            $r = false;
            $transaction->rollBack();
        }

        return $r;
    }

    /**
     * @return bool
     */
    public function unpublishedCart(): bool
    {
        if ($this->cart !== null) {
            $this->cart->published = 0;
            return $this->saveCart();
        }
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

            //пересчистав итем нужно его сохранить, чтобы правильно пересчитать корзину
            $this->saveCart($cartItemKey);
        }

        //посчитаем скидку на весь заказ
        $this->cart = CartModel::findBySessionID();
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
                $this->items[$cartItemKey]->setScenario('addCartItem');
                $this->items[$cartItemKey]->save();
            }
            $this->cart->setScenario('addCart');
            if ($this->cart->save()) {
                $transaction->commit();
                $r = true;
            } else {
                $transaction->rollBack();
                $r = false;
            }
        } catch (Exception $e) {
            Yii::getLogger()->log($e->getMessage(), Logger::LEVEL_ERROR);
            $r = false;
            $transaction->rollBack();
        }

        return $r;
    }

    /**
     * @param $cartItemKey
     * @return bool
     */
    protected function deleteFromCart($cartItemKey)
    {
        $r = true;
        $transaction = CartModel::getDb()->beginTransaction();
        try {
            if ($cartItemKey !== false) {
                if ($this->items[$cartItemKey]->delete()) {
                    $transaction->commit();
                    $r = true;
                } else {
                    $transaction->rollBack();
                    $r = false;
                }
            }

        } catch (Exception $e) {
            Yii::getLogger()->log($e->getMessage(), Logger::LEVEL_ERROR);
            $r = false;
            $transaction->rollBack();
        }

        return $r;
    }

    /**
     * @return bool
     */
    public function deleteCart()
    {
        $r = true;
        $transaction = CartModel::getDb()->beginTransaction();
        try {
            if ($this->cart) {
                if ($this->cart->delete()) {
                    $transaction->commit();
                    $r = true;
                } else {
                    $transaction->rollBack();
                    $r = false;
                }
            }

        } catch (Exception $e) {
            Yii::getLogger()->log($e->getMessage(), Logger::LEVEL_ERROR);
            $r = false;
            $transaction->rollBack();
        }

        return $r;
    }

    /**
     * @return bool
     * @throws ErrorException
     */
    public function updateCart()
    {
        if (empty($this->cart) && !$this->newCart()) {
            throw new ErrorException('Cart can not create!');
        }

        if ($this->items === []) {
            return false;
        }

        foreach ($this->items as $key => $item) {

            $product = call_user_func([$this->threadProductClass, 'findByID'], $item['product_id']);

            if (empty($product)) {
                throw new ErrorException('Can not find this product!');
            }

            $cartItemKey = $this->findProductInItems($product->id);

            // если товар уже в корзине увеличуем его количество
            if ($cartItemKey !== false) {
                $this->items[$cartItemKey]->price = $product->getPrice();
            }

            // пересчитаем сумму
            $this->items[$cartItemKey]->recalculate();

            // пересчитаем сумму
            $this->cart->recalculate();

            // пересчистав итем нужно его сохранить, чтобы правильно пересчитать корзину
            $this->saveCart($cartItemKey);
        }
    }
}
