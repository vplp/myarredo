<?php

namespace frontend\modules\shop\models;

use yii\helpers\Url;

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
        return [
            'addNewOrder' => [
                'delivery_method_id',
                'payment_method_id',
                'delivery_price',
                'order_status',
                'payd_status',
                'comment',
                'items_summ',
                'items_total_summ',
                'discount_percent',
                'discount_money',
                'discount_full',
                'total_summ',
                'customer_id',
                'items_count',
                'items_total_count',
                'token',
                'published',
                'deleted'],
        ];
    }

    /**
     * @return mixed
     */
    public static function findBase()
    {
        return parent::findBase()->innerJoinWith(['items'])->enabled();
    }

    /**
     * @return mixed
     */
    public function getItems()
    {
        return $this->hasMany(OrderItem::class, ['order_id' => 'id']);
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
        return self::findBase()->byId($id)->one();
    }

    /**
     * @param $customer_id
     * @return mixed
     */
    public static function findByCustomerId($customer_id)
    {
        return self::findBase()->customer($customer_id)->all();
    }

    /**
     * @param $user_id
     * @return mixed
     */
    public static function findByUserId($user_id)
    {
        return self::findBase()
            ->innerJoinWith(['customer'])
            ->andWhere([Customer::tableName().'.user_id' => $user_id])
            ->all();
    }

    /**
     * @param $token
     * @return mixed
     */
    public static function findByLink($token)
    {
        return self::findBase()->token($token)->one();
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
        return self::findBase()->byId($id)->customer($customer_id)->one();
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
            ->andWhere([Customer::tableName().'.user_id' => $user_id])
            ->one();
    }
}