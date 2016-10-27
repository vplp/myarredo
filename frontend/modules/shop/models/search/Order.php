<?php

namespace frontend\modules\shop\models\search;

use Yii;
use yii\base\Exception;
use yii\log\Logger;
use frontend\modules\shop\models\{
    Cart, CartCustomerForm, DeliveryMethods, OrderItem, PaymentMethods, Order as FrontendOrderModel, Customer
};



/**
 * Class Order
 * @package frontend\modules\shop\models\search
 * @author Alla Kuzmenko
 * @copyright (c) 2016, VipDesign
 */
class Order extends FrontendOrderModel
{

    /**
     * @param Cart $cart
     * @param CartCustomerForm $customerform the model being validated
     * @return integer
     */
    public static function addNewOrder(Cart $cart, CartCustomerForm $customerform)
    {
        //сначала добавляем покупателя и получаем его id
        $customer_id = self::addNewCustomer($customerform);

        $order = new FrontendOrderModel();
        $order->scenario = 'addneworder';
        //переносим все одинаковые атрибуты из корзины в заказ
        $order->setAttributes($cart->getAttributes());
        //переносим все атрибуты из заполненой формы в заказ
        $order->setAttributes($customerform->getAttributes());
        $order->customer_id = $customer_id;
        $order->generateToken();
        $order->delivery_method_id = DeliveryMethods::findIdByAlias($customerform->delivery)['id'];
        if (empty($order->delivery_method_id)) {
            //ошибка
        }
        $order->payment_method_id = PaymentMethods::findIdByAlias($customerform->pay)['id'];
        if (empty($order->payment_method_id)) {
            //ошибка
        }
        $transaction = $order::getDb()->beginTransaction();
        try {
            if ($order->validate() && $order->save()) {
                foreach ($cart->items as $cartItem) {
                    $orderItem = new OrderItem();
                    $orderItem->scenario = 'addneworderitem';
                    //переносим все одинаковые атрибуты из корзины в заказ
                    $orderItem->order_id = $order->id;
                    $orderItem->setAttributes($cartItem->getAttributes());
                    if (!$orderItem->save()) {
                        $transaction->rollBack();
                    }
                }
                $transaction->commit();
                //TODO::сделать отпарвку письма (в письме должна быть ссылка $order->getTokenLink())
                return $order->id;
            } else {
                $transaction->rollBack();
                //ошибка
                //print_r($order->getErrors());
            }
        } catch (Exception $e) {
            Yii::getLogger()->log($e->getMessage(), Logger::LEVEL_ERROR);
            $transaction->rollBack();
            return false;
        }
    }

    /**
     * @param CartCustomerForm $customerform the model being validated
     * @return integer
     */
    public static function addNewCustomer(CartCustomerForm $customerform)
    {
        $customer = Customer::find()->andWhere(['email' => $customerform['email']])->one();

        if ($customer === null) {
            $customer = new Customer();
            $customer->scenario = 'addnewcustorem';
            $customer->user_id = Yii::$app->getUser()->id ?? 0;
            $customer->email = $customerform['email'];
            $customer->phone = $customerform['phone'];
            $customer->full_name = $customerform['full_name'];

            $transaction = $customer::getDb()->beginTransaction();
            try {
                if ($customer->save()) {
                    $transaction->commit();

                } else {
                    $transaction->rollBack();
                }

            } catch (Exception $e) {
                Yii::getLogger()->log($e->getMessage(), Logger::LEVEL_ERROR);
                $transaction->rollBack();
            }
        }
        return $customer->id;

    }


}