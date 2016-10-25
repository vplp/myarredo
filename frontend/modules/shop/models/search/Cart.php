<?php

namespace frontend\modules\shop\models\search;

use Yii;
use frontend\modules\shop\models\{
    CartCustomerForm, CartItem, DeliveryMethods, OrderItem, Order, PaymentMethods, Cart as FrontendCartModel, Customer
};


/**
 * Class Cart
 * @package frontend\modules\shop\models\search
 * @author Alla Kuzmenko
 * @copyright (c) 2016, VipDesign
 */
class Cart extends FrontendCartModel
{

    /**
     * @return  Model $cart
     */
    public static function addNewCart()
    {
        $transaction = self::getDb()->beginTransaction();
        try {
            $cart = new FrontendCartModel([
                'phpsessid' => self::getSessionID(),
                'user_id' => Yii::$app->getUser()->getId(),
                'scenario' => 'addcart',
            ]);

            ($cart->save()) ? $transaction->commit() : $transaction->rollBack();
        } catch (Exception $e) {
            $transaction->rollBack();
        }

        return $cart;
    }

    /**
     * @return  Model $cart
     */
    public static function addNewCartItem($id, Cart $cart, $extra_param = '', $count = 1)
    {
        $save = false;
        exit();
        $transaction = CartItem::getDb()->beginTransaction();
        try {

            $item = Article::findByID($id);

            if ($item !== null) {

                $goods = (new CartGoods([
                    'cart_id' => $cart->id,
                    'item_id' => $item->id,
                    'price' => $item->getPriceActual(),
                    'discount' => 0,
                    'count' => $count,
                    'extra_param' => $extra_param,
                    'scenario' => 'addgoods',
                ]))->recalculate();

                $save = $goods->save();

                ($save) ? $transaction->commit() : $transaction->rollBack();
            }
        } catch (Exception $e) {
            $transaction->rollBack();
        }

        return $save;
    }



}