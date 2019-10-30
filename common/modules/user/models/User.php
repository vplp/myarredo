<?php

namespace common\modules\user\models;

use common\modules\shop\models\{
    OrderAnswer, OrderItemPrice
};

/**
 * Class User
 *
 * @property Profile $profile
 * @property Group $group
 * @property OrderAnswer $orderAnswer
 * @property OrderItemPrice $orderItemPrice
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
    public function getOrderItemPrice()
    {
        return $this->hasMany(OrderItemPrice::class, ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderAnswerCount()
    {
        return $this->getOrderAnswer()->count();
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
}
