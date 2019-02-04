<?php

namespace frontend\modules\shop\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\base\Exception;
use yii\log\Logger;
//
use frontend\modules\shop\Shop;
use frontend\modules\shop\models\{
    CartCustomerForm,
    OrderItem,
    Order as OrderModel,
    Customer
};

/**
 * Class Order
 *
 * @package frontend\modules\shop\models\search
 */
class Order extends OrderModel
{
    public $factory_id;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['id', 'customer_id', 'city_id', 'factory_id'], 'integer'],
        ];
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return Model::scenarios();
    }

    /**
     * @param $query
     * @param $params
     * @return ActiveDataProvider
     * @throws \Throwable
     */
    public function baseSearch($query, $params)
    {
        /** @var Shop $module */
        $module = Yii::$app->getModule('shop');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => $module->itemOnPage,
                'forcePageParam' => false,
            ],
        ]);

        if (!($this->load($params, ''))) {
            return $dataProvider;
        }

        $query
            ->andFilterWhere([
                'id' => $this->id,
                self::tableName() . '.customer_id' => $this->customer_id,
            ]);

        if (isset($params['city_id']) && is_array($params['city_id'])) {
            $query
                ->andFilterWhere(['IN', self::tableName() . '.city_id', $params['city_id']]);
        } elseif (isset($params['city_id']) && $params['city_id'] > 0) {
            $query
                ->andFilterWhere([
                    self::tableName() . '.city_id' => $params['city_id'],
                ]);
        }

        $query
            ->groupBy(self::tableName() . '.id');

        if (Yii::$app->getUser()->getIdentity()->group->role == 'factory') {
            $query
                ->innerJoinWith(["items.product product"], false)
                ->andFilterWhere(['IN', 'product.factory_id', $this->factory_id]);
        }

        return $dataProvider;
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     * @throws \Throwable
     */
    public function search($params)
    {
        $query = OrderModel::findBase();
        return $this->baseSearch($query, $params);
    }

    /**
     * @param $cart
     * @param CartCustomerForm $customerForm
     * @return array|bool
     */
    public static function addNewOrder($cart, CartCustomerForm $customerForm)
    {
        $session = Yii::$app->session;

        $session->set('order_email', $customerForm['email']);
        $session->set('order_phone', $customerForm['phone']);
        $session->set('order_full_name', $customerForm['full_name']);

        // сначала добавляем покупателя и получаем его id
        $customer_id = self::addNewCustomer($customerForm);

        $order = new OrderModel();
        $order->scenario = 'addNewOrder';

        // переносим все одинаковые атрибуты из корзины в заказ
        $order->setAttributes($cart->getAttributes());

        // переносим все атрибуты из заполненой формы в заказ
        $order->setAttributes($customerForm->getAttributes());
        $order->lang = Yii::$app->language;
        $order->customer_id = $customer_id;

        $order->generateToken();
        /** @var PDO $transaction */
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

        if ($customer == null) {
            $customer = new Customer();

            $customer->scenario = 'addNewCustomer';

            $customer->user_id = Yii::$app->getUser()->id ?? 0;
            $customer->setAttributes($customerForm->getAttributes());
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
