<?php

namespace frontend\modules\shop\models\search;

use Yii;
use yii\base\Exception;
use yii\log\Logger;
use frontend\modules\shop\models\{
    CartCustomerForm,
    OrderItem,
    Order as FrontendOrderModel,
    Customer
};

/**
 * Class Order
 *
 * @package frontend\modules\shop\models\search
 */
class Order extends FrontendOrderModel
{
    /**
     * @param $cart
     * @param CartCustomerForm $customerForm
     * @return array|bool
     */
    public static function addNewOrder($cart, CartCustomerForm $customerForm)
    {
        // сначала добавляем покупателя и получаем его id
        $customer_id = self::addNewCustomer($customerForm);

        $order = new FrontendOrderModel();
        $order->scenario = 'addNewOrder';

        // переносим все одинаковые атрибуты из корзины в заказ
        $order->setAttributes($cart->getAttributes());

        // переносим все атрибуты из заполненой формы в заказ
        $order->setAttributes($customerForm->getAttributes());
        $order->customer_id = $customer_id;
        $order->city_id = Yii::$app->city->getCityId();

        $order->generateToken();

        $transaction = $order::getDb()->beginTransaction();
        try {
            if ($order->validate() && $order->save()) {
                foreach ($cart->items as $cartItem) {
                    $orderItem = new OrderItem();

                    $orderItem->scenario = 'addNewOrderItem';

                    // переносим все одинаковые атрибуты из корзины в заказ
                    $orderItem->order_id = $order->id;
                    $orderItem->setAttributes($cartItem->getAttributes());

                    $orderItem->price = $cartItem->price;
                    $orderItem->discount_percent = $cartItem->discount_percent;

                    if (!$orderItem->save()) {
                        $transaction->rollBack();
                    }
                }
                $transaction->commit();

                return [
                    'id' => $order->id,
                    'total_summ' => $order->total_summ,
                    'link' => $order->getTokenLink()
                ];
            } else {
                $transaction->rollBack();
            }
        } catch (Exception $e) {
            Yii::getLogger()->log($e->getMessage(), Logger::LEVEL_ERROR);
            $transaction->rollBack();
            return false;
        }
    }

    /**
     * @param CartCustomerForm $customerForm the model being validated
     * @return integer
     */
    public static function addNewCustomer(CartCustomerForm $customerForm)
    {
        $customer = Customer::find()->andWhere(['email' => $customerForm['email']])->one();

        if ($customer === null) {

            $customer = new Customer();

            $customer->scenario = 'addNewCustomer';

            $customer->user_id = Yii::$app->getUser()->id ?? 0;
            $customer->setAttributes($customerForm->getAttributes());

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
