<?php

namespace common\modules\shop\modules\market\models;

use Yii;
use thread\app\base\models\ActiveRecord;
use common\modules\shop\Shop;
use common\modules\user\models\User;

/**
 * Class MarketOrderAnswer
 *
 * @property integer $id
 * @property integer $order_id
 * @property integer $user_id
 * @property float $commission_percentage
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $published
 * @property integer $deleted
 *
 * @property User $user
 * @property MarketOrder $order
 *
 * @package common\modules\shop\models
 */
class MarketOrderAnswer extends ActiveRecord
{
    /**
     * @return string
     */
    public static function getDb()
    {
        return Shop::getDb();
    }

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%shop_market_order_answer}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['commission_percentage'], 'required'],
            ['order_id', 'exist', 'targetClass' => MarketOrder::class, 'targetAttribute' => 'id'],
            ['user_id', 'exist', 'targetClass' => User::class, 'targetAttribute' => 'id'],
            [['created_at', 'updated_at'], 'integer'],
            [['commission_percentage'], 'double'],
            [['commission_percentage'], 'default', 'value' => 0],
        ];
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return [
            'frontend' => [
                'order_id',
                'user_id',
                'commission_percentage',
            ],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'order_id' => Yii::t('app', 'Order id'),
            'user_id' => Yii::t('app', 'User'),
            'commission_percentage',
            'created_at' => Yii::t('app', 'Create time'),
            'updated_at' => Yii::t('app', 'Update time'),
            'published' => Yii::t('app', 'Published'),
            'deleted' => Yii::t('app', 'Deleted'),
        ];
    }

    /**
     * @param $order_id
     * @param $user_id
     * @return mixed
     */
    public static function findByOrderIdUserId($order_id, $user_id)
    {
        return self::findBase()
            ->andWhere([
                self::tableName() . '.order_id' => $order_id,
                self::tableName() . '.user_id' => $user_id
            ])
            ->one();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(MarketOrder::class, ['id' => 'order_id']);
    }
}
