<?php

namespace frontend\modules\shop\models;

use Yii;
use yii\helpers\{
    Url, ArrayHelper
};

/**
 * Class Order
 *
 * @package frontend\modules\shop\models
 */
class Order extends \common\modules\shop\models\Order
{
    /**
     * @return array
     */
    public function scenarios()
    {
        return ArrayHelper::merge(parent::scenarios(), [
            'addNewOrder' => [
                'product_type',
                'lang',
                'delivery_method_id',
                'payment_method_id',
                'order_status',
                'comment',
                'customer_id',
                'city_id',
                'items_count',
                'items_total_count',
                'token',
                'published',
                'deleted'
            ],
        ]);
    }

    /**
     * @return mixed|\yii\db\ActiveQuery
     * @throws \Throwable
     */
    public function getItems()
    {
        $query = $this->hasMany(OrderItem::class, ['order_id' => 'id']);

        if (!Yii::$app->getUser()->isGuest && Yii::$app->user->identity->group->role == 'factory') {
            $query
                ->innerJoinWith(["product product"], false)
                ->andFilterWhere(['IN', 'product.factory_id', Yii::$app->user->identity->profile->factory_id]);
        }

        return $query;
    }

    /**
     * @return mixed
     */
    public static function findBase()
    {
        return parent::findBase()
            ->innerJoinWith(['items'])
            ->enabled();
    }

    /**
     * @return mixed
     */
    public static function findBaseAll()
    {
        return self::findBase()->all();
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function findById($id)
    {
        return self::findBase()
            ->byId($id)
            ->one();
    }

    /**
     * @param $customer_id
     * @return mixed
     */
    public static function findByCustomerId($customer_id)
    {
        return self::findBase()
            ->customer($customer_id)
            ->all();
    }

    /**
     * @param $user_id
     * @return mixed
     */
    public static function findByUserId($user_id)
    {
        return self::findBase()
            ->innerJoinWith(['customer'])
            ->andWhere([Customer::tableName() . '.user_id' => $user_id])
            ->all();
    }

    /**
     * @param $token
     * @return mixed
     */
    public static function findByLink($token)
    {
        return self::findBase()
            ->token($token)
            ->one();
    }

    /**
     * @return string
     */
    public function getTokenLink()
    {
        return Url::toRoute(['/shop/order/link', 'token' => $this->token], true);
    }

    /**
     * @param $id
     * @param $customer_id
     * @return mixed
     */
    public static function findByIdCustomerId($id, $customer_id)
    {
        return self::findBase()
            ->byId($id)
            ->customer($customer_id)
            ->one();
    }

    /**
     * @param $id
     * @param $user_id
     * @return mixed
     */
    public static function findByIdUserId($id, $user_id)
    {
        return self::findBase()
            ->byId($id)
            ->innerJoinWith(['customer'])
            ->andWhere([Customer::tableName() . '.user_id' => $user_id])
            ->one();
    }

    /**
     * @return string
     */
    public function getOrderUrl()
    {
        return Url::toRoute(['/shop/order/view', 'id' => $this->id]);
    }

    /**
     * @return string
     */
    public function getPartnerOrderOnListUrl()
    {
        return Url::toRoute(['/shop/partner-order/list']) . '#' . $this->id;
    }

    /**
     * @return string
     */
    public function getPartnerOrderUrl()
    {
        return Url::toRoute(['/shop/partner-order/view', 'id' => $this->id]);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     * @throws \Throwable
     */
    public function search($params)
    {
        return (new search\Order())->search($params);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function trash($params)
    {
        return (new search\Order())->trash($params);
    }
}
