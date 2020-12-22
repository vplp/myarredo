<?php

namespace frontend\modules\shop\models;

use Yii;
use yii\helpers\{
    Url, ArrayHelper
};
use frontend\modules\location\models\{
    City, Country
};

/**
 * Class Order
 *
 * @package frontend\modules\shop\models
 */
class Order extends \common\modules\shop\models\Order
{
    /**
     * @return mixed
     */
    public static function findBase()
    {
        return self::find()
            ->innerJoinWith([/*'items',*/'customer'])
            ->orderBy(['created_at' => SORT_DESC])
            ->enabled();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customer::class, ['id' => 'customer_id'])->cache(60 * 60 * 2);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::class, ['id' => 'city_id'])->cache(60 * 60 * 2);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::class, ['id' => 'country_id'])->cache(60 * 60 * 2);
    }

    /**
     * @return mixed|\yii\db\ActiveQuery
     * @throws \Throwable
     */
    public function getItems()
    {
        return $this->hasMany(OrderItem::class, ['order_id' => 'id']);
    }

    /**
     * @return mixed
     */
    public function getOrderAnswers()
    {
        return $this
            ->hasMany(OrderAnswer::class, ['order_id' => 'id'])
            ->andWhere(OrderAnswer::tableName() . '.answer_time > 0');
    }

    /**
     * @return mixed
     */
    public function getOrderAnswer()
    {
        $modelAnswer = OrderAnswer::findByOrderIdUserId(
            $this->id,
            Yii::$app->getUser()->getId()
        );

        if ($modelAnswer == null) {
            $modelAnswer = new OrderAnswer();
        }

        return $modelAnswer;
    }

    /**
     * @return mixed
     */
    public static function findBaseAll()
    {
        return self::findBase()->all();
    }

    /**
     * @return mixed
     */
    public static function dropDownListOrderYears()
    {
        $query = self::find()
            ->select(['DISTINCT YEAR(FROM_UNIXTIME(created_at)) as years'])
            ->orderBy('years DESC');

        $data = $query->asArray()->all();

        return ArrayHelper::map($data, 'years', 'years');
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
        return Url::toRoute(['/shop/partner-order/list']) . '?' . $this->id;
    }

    /**
     * @return string
     */
    public function getPartnerOrderOnListItalyUrl()
    {
        return Url::toRoute(['/shop/partner-order/list-italy']) . '?' . $this->id;
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
