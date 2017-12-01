<?php

namespace common\modules\shop\models;

use Yii;
//
use thread\app\base\models\ActiveRecord;
use common\modules\shop\Shop;

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
}