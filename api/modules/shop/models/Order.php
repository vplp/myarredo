<?php

namespace api\modules\shop\models;

use yii\log\Logger;
use yii\base\Exception;
use frontend\modules\shop\models\Customer;
use frontend\modules\shop\models\OrderItem;
use common\modules\shop\models\Order as ParentModel;

/**
 * Class Order
 *
 * @package api\modules\shop\models
 */
class Order extends ParentModel
{
    /**
     * @param $bodyParams
     * @return Order|false
     */
    public static function addNewOrder($bodyParams)
    {
        $customer_id = self::addNewCustomer($bodyParams['user']);

        $order = new Order();
        $order->scenario = 'addNewOrder';

        $order->product_type = 'product';
        $order->lang = 'ru-RU';
        $order->country_id = 2;
        $order->city_id = 4;
        $order->customer_id = $customer_id;
        $order->admin_comment = 'Яндекс.Турбо';

        $order->generateToken();

        /** @var PDO $transaction */
        $transaction = $order::getDb()->beginTransaction();
        try {
            if ($order->validate() && $order->save()) {
                foreach ($bodyParams['items'] as $item) {
                    $orderItem = new OrderItem();

                    $orderItem->scenario = 'addNewOrderItem';

                    $orderItem->order_id = $order->id;
                    $orderItem->product_id = $item['offerId'];
                    $orderItem->count = $item['count'];
                    $orderItem->price = $item['price'];

                    $orderItem->save();
                }
                $transaction->commit();

                return $order;
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
     * @param $user
     * @return int
     */
    public static function addNewCustomer($user)
    {
        $customer = Customer::find()->andWhere(['email' => $user['email']])->one();

        if ($customer == null) {
            $customer = new Customer();

            $customer->scenario = 'addNewCustomer';

            $customer->user_id = 0;
            $customer->email = $user['email'];
            $customer->phone = $user['phone'];
            $customer->full_name = $user['name'];

            /** @var PDO $transaction */
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
