<?php

namespace frontend\modules\shop\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\base\Exception;
use yii\log\Logger;
use frontend\modules\shop\Shop;
use frontend\modules\shop\models\{
    CartCustomerForm,
    OrderItem,
    Order as OrderModel,
    Customer
};
use frontend\modules\catalog\models\ItalianProduct;

/**
 * Class Order
 *
 * @package frontend\modules\shop\models\search
 */
class Order extends OrderModel
{
    public $factory_id;

    public $year;

    public $start_date;

    public $end_date;

    public $email;

    public $phone;

    public $full_name;


    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['lang', 'string', 'min' => 5, 'max' => 5],
            [['product_type'], 'in', 'range' => array_keys(self::productTypeKeyRange())],
            [['id', 'customer_id', 'country_id', 'city_id', 'factory_id', 'year'], 'integer'],
            [['start_date', 'end_date'], 'string', 'max' => 10],
            [['email', 'full_name', 'phone'], 'string', 'max' => 50],
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
                'defaultPageSize' => isset($params['defaultPageSize']) ? $params['defaultPageSize'] : $module->itemOnPage,
                'forcePageParam' => false,
            ],
        ]);

        if (!($this->load($params, ''))) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            self::tableName() . '.customer_id' => $this->customer_id,
            self::tableName() . '.product_type' => $this->product_type,
        ]);


        $countries = [];

        if (in_array(Yii::$app->user->identity->group->role, ['partner', 'factory', 'settlementCenter'])) {
            $modelCountries = Yii::$app->getUser()->getIdentity()->profile->countries;
            if ($modelCountries != null) {
                $countries = [];
                foreach ($modelCountries as $item) {
                    $countries[] = $item['id'];
                }
                $query->andFilterWhere(['IN', self::tableName() . '.country_id', $countries]);
            }
        }

        if (empty($countries) && isset($params['country_id']) && $params['country_id'] > 0) {
            $query->andFilterWhere([self::tableName() . '.country_id' => $params['country_id']]);
        }

        if (isset($params['city_id']) && $params['city_id'] > 0) {
            $query->andFilterWhere([self::tableName() . '.city_id' => $params['city_id']]);
        }

        if (isset($params['lang'])) {
            $query->andFilterWhere([self::tableName() . '.lang' => $params['lang']]);
        }

        if (isset($params['year']) && in_array($params['year'], self::dropDownListOrderYears())) {
            $date_from = mktime(0, 0, 0, 1, 1, $params['year']);
            $date_to = mktime(23, 59, 0, 12, 31, $params['year']);

            $query->andFilterWhere(['>=', self::tableName() . '.created_at', $date_from]);
            $query->andFilterWhere(['<=', self::tableName() . '.created_at', $date_to]);
        }

        if (isset($params['full_name'])) {
            $query->andFilterWhere(['like', Customer::tableName() . '.full_name', $params['full_name']]);
        }

        if (isset($params['email'])) {
            $query->andFilterWhere(['like', Customer::tableName() . '.email', $params['email']]);
        }

        if (isset($params['phone'])) {
            $query->andFilterWhere(['like', Customer::tableName() . '.phone', $params['phone']]);
        }

        if ($params['product_type'] == 'product' && $params['full_name'] == '' &&
            $params['email'] == '' &&
            $params['phone'] == '' &&
            isset($params['start_date']) && $params['start_date'] != '' &&
            isset($params['end_date']) && $params['end_date'] != '') {
            $query->andWhere(['>=', self::tableName() . '.created_at', strtotime($params['start_date'] . ' 0:00')]);
            $query->andWhere(['<=', self::tableName() . '.created_at', strtotime($params['end_date'] . ' 23:59')]);
        }

        if ($params['product_type'] != 'product' &&
            isset($params['start_date']) && $params['start_date'] != '' &&
            isset($params['end_date']) && $params['end_date'] != '') {
            $query->andWhere(['>=', self::tableName() . '.created_at', strtotime($params['start_date'] . ' 0:00')]);
            $query->andWhere(['<=', self::tableName() . '.created_at', strtotime($params['end_date'] . ' 23:59')]);
        }

        $query->groupBy(self::tableName() . '.id');

        /*if (Yii::$app->user->identity->group->role == 'factory') {
            $query
                ->innerJoinWith(["items.product product"], false)
                ->andFilterWhere(['IN', 'product.factory_id', Yii::$app->user->identity->profile->factory_id]);
        }*/

        // possibility_to_answer_com_de
        if (Yii::$app->user->identity->group->role == 'partner' && !Yii::$app->user->identity->profile->possibility_to_answer_com_de) {
            $query
                ->andFilterWhere(['NOT IN', self::tableName() . '.lang', ['it-IT', 'en-EN', 'de-DE']]);
        }

        if (isset($params['factory_id']) && $params['factory_id'] > 0) {
            if ($this->product_type == 'sale-italy') {
                $subQueryFactory = OrderModel::find()
                    ->select(OrderModel::tableName() . '.id')
                    ->innerJoinWith(["items.italianProduct italianProduct"], false)
                    ->andFilterWhere(['IN', 'italianProduct.factory_id', $params['factory_id']]);
            } else {
                $subQueryFactory = OrderModel::find()
                    ->select(OrderModel::tableName() . '.id')
                    ->innerJoinWith(["items.product product"], false)
                    ->andFilterWhere(['IN', 'product.factory_id', $params['factory_id']]);
            }

            $query->andFilterWhere([
                'AND',
                ['in', self::tableName() . '.id', $subQueryFactory]
            ]);
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

        /**
         * склеивание заказа
         */

        $order = OrderModel::findBase()
            ->andFilterWhere([
                self::tableName() . '.customer_id' => $customer_id
            ])
            ->one();

        /** @var $order OrderModel */

        if (!empty($order) && empty($order->orderAnswers) && $order->created_at > strtotime("-15 minutes", time())) {
            $IDs = [];
            foreach ($order->items as $item) {
                $IDs[] = $item['product_id'];
            }

            foreach ($cart->items as $cartItem) {
                if (!in_array($cartItem['product_id'], $IDs)) {
                    $orderItem = new OrderItem();

                    $orderItem->scenario = 'addNewOrderItem';

                    // переносим все одинаковые атрибуты из корзины в заказ
                    $orderItem->order_id = $order->id;
                    $orderItem->setAttributes($cartItem->getAttributes());

                    $orderItem->price = $cartItem->price;
                    $orderItem->discount_percent = $cartItem->discount_percent;

                    $orderItem->save();
                }
            }

            $order->scenario = 'addNewOrder';

            $session = Yii::$app->session;
            $order->order_first_url_visit = $session->get('order_first_url_visit');
            $order->order_count_url_visit = $session->get('order_count_url_visit');
            $order->order_mobile = Yii::$app->getModule('shop')->isMobileDevice();

            //$session->remove('order_first_url_visit');
            //$session->remove('order_count_url_visit');

            $order->save();

            return $order;
        }

        /**
         * новый заказ
         */
        $order = new OrderModel();
        $order->scenario = 'addNewOrder';

        // переносим все одинаковые атрибуты из корзины в заказ
        $order->setAttributes($cart->getAttributes());

        // переносим все атрибуты из заполненой формы в заказ
        $order->setAttributes($customerForm->getAttributes());

        if ($customerForm->country_code) {
            $order->country_id = $customerForm->country->id;
        }

        $order->product_type = 'product';

        foreach ($cart->items as $cartItem) {
            if (ItalianProduct::findById($cartItem->product_id) != null) {
                $order->product_type = 'sale-italy';
                break;
            }
        }

        $order->lang = Yii::$app->language;
        $order->customer_id = $customer_id;

        $session = Yii::$app->session;
        $order->order_first_url_visit = $session->get('order_first_url_visit');
        $order->order_count_url_visit = $session->get('order_count_url_visit');
        $order->order_mobile = Yii::$app->getModule('shop')->isMobileDevice();

        //$session->remove('order_first_url_visit');
        //$session->remove('order_count_url_visit');

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
