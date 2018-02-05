<?php

namespace common\modules\shop\models;

use Yii;
//
use thread\app\base\models\ActiveRecord;
use common\modules\shop\Shop;
use common\modules\user\models\User;

/**
 * Class OrderItemPrice
 *
 * @property integer $id
 * @property integer $order_id
 * @property integer $user_id
 * @property integer $product_id
 * @property float $price
 *
 * @package common\modules\shop\models
 */
class OrderItemPrice extends ActiveRecord
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
        return '{{%shop_order_item_price}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['order_id', 'user_id', 'product_id'], 'required'],
            [['order_id', 'user_id', 'product_id'], 'integer'],
            [['price'], 'double'],
            ['price', 'compare', 'compareValue' => 108, 'operator' => '>=', 'message'=>'You cannot invite yourself.'],
        ];
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return [
            'backend' => [
                'order_id',
                'user_id',
                'product_id',
                'price',
            ],
            'frontend' => [
                'order_id',
                'user_id',
                'product_id',
                'price',
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
            'user_id' => Yii::t('app', 'User id'),
            'product_id' => Yii::t('app', 'Product id'),
            'price' => Yii::t('app', 'Price'),
            'created_at' => Yii::t('app', 'Create time'),
            'updated_at' => Yii::t('app', 'Update time'),
        ];
    }

    /**
     * @param $order_id
     * @param $user_id
     * @param $product_id
     * @return mixed
     */
    public static function findByOrderIdUserIdProductId($order_id, $user_id, $product_id)
    {
        return self::findBase()
            ->andWhere([
                self::tableName().'.order_id' => $order_id,
                self::tableName().'.user_id' => $user_id,
                self::tableName().'.product_id' => $product_id
            ])
            ->one();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this
            ->hasOne(User::class, ['id' => 'user_id']);
    }
}