<?php

namespace common\modules\shop\models;

use Yii;

/**
 * Class Order
 *
 * @property Customer[] $customer
 *
 * @package common\modules\shop\models
 */
class Order extends \thread\modules\shop\models\Order
{
    /**
     * @return mixed
     */
    public static function findBase()
    {
        return self::find()->innerJoinWith(['items'])->orderBy(['created_at' => SORT_DESC]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customer::class, ['id' => 'customer_id']);
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
    public function getOrderAnswer()
    {

        $modelAnswer = OrderAnswer::findByOrderIdUserId($this->id, Yii::$app->getUser()->getId());

        if (empty($modelAnswer)) {
            $modelAnswer = new OrderAnswer();
        }

        return $modelAnswer;
    }
}