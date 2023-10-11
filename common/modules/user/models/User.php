<?php

namespace common\modules\user\models;

use yii\helpers\ArrayHelper;
use common\modules\catalog\models\Factory;
use common\modules\catalog\models\FactoryRelDealers;
use common\modules\shop\models\{
    OrderAnswer, OrderItemPrice
};
use common\modules\catalog\models\FactoryFileClickStats;

/**
 * Class User
 *
 * @property Profile $profile
 * @property Group $group
 * @property OrderAnswer $orderAnswer
 * @property OrderItemPrice $orderItemPrice
 *
 * @property FactoryRelDealers[] $factoryDealers
 *
 * @package common\modules\user\models
 */
class User extends \thread\modules\user\models\User
{
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(Group::class, ['id' => 'group_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(Profile::class, ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderAnswer()
    {
        return $this->hasMany(OrderAnswer::class, ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFactoryFileClickStats()
    {
        return $this->hasMany(FactoryFileClickStats::class, ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getFactoryDealers()
    {
        return $this
            ->hasMany(Factory::class, ['id' => 'factory_id'])
            ->viaTable(FactoryRelDealers::tableName(), ['dealer_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFactoryFileClickStatsCount()
    {
        return self::getFactoryFileClickStats()->sum('views');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderItemPrice()
    {
        return $this->hasMany(OrderItemPrice::class, ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderAnswerCountPerMonth()
    {
        $timestamp = time();
        $date_from = mktime(0, 0, 0, date("m", $timestamp), 1, date("Y", $timestamp));
        $date_to = mktime(23, 59, 0, date("m", $timestamp), date("t", $timestamp), date("Y", $timestamp));

        return $this->getOrderAnswer()
            ->andFilterWhere(['>=', 'answer_time', $date_from])
            ->andFilterWhere(['<=', 'answer_time', $date_to])
            ->count();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderItemPriceTotalCost()
    {
        return $this->getOrderItemPrice()->sum('price');
    }

    /**
     * @return mixed
     */
    public static function findBase()
    {
        return self::find()
            ->joinWith([
                'group',
                'group.lang',
                'profile',
                'profile.lang'
            ]);
    }

    /**
     * Backend form drop down list
     * @return array
     */
    public static function dropDownList()
    {
        return ArrayHelper::map(self::findBase()->enabled()->all(), 'id', 'email');
    }

    /**
     * Backend form drop down list
     * @return array
     */
    public static function dropDownListPartner()
    {
        $query = self::findBase()
            ->andWhere(Group::tableName() . ".role = 'partner'")
            ->enabled()
            ->all();

        return ArrayHelper::map($query, 'id', function ($item) {
            return ($item['profile']['lang'] ? $item['profile']['lang']['name_company'] : '')
                . ' (' . $item['email'] . ')';
        });
    }
}
