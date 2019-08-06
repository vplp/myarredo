<?php

namespace thread\modules\shop\models;

use Yii;
//
use thread\app\base\models\ActiveRecord;
use thread\modules\shop\Shop;

/**
 * Class OrderItem
 *
 * @property integer $id
 * @property integer $order_id
 * @property integer $product_id
 * @property integer $count
 * @property float $price
 * @property float $discount_percent
 * @property float $discount_money
 * @property float $discount_full
 * @property float $summ
 * @property float $total_summ
 * @property string $extra_param
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $published
 * @property integer $deleted
 *
 * @package thread\modules\shop\models
 */
class OrderItem extends ActiveRecord
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
        return '{{%shop_order_item}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['order_id', 'product_id'], 'required'],
            [['order_id', 'product_id', 'count', 'created_at', 'updated_at'], 'integer'],
            [['price', 'summ', 'total_summ', 'discount_percent', 'discount_money', 'discount_full'], 'double'],
            [['extra_param'], 'string'],
            [['published', 'deleted'], 'in', 'range' => array_keys(self::statusKeyRange())],
        ];
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return [
            'published' => ['published'],
            'deleted' => ['deleted'],
            'backend' => [
                'order_id',
                'product_id',
                'summ',
                'total_summ',
                'discount_percent',
                'discount_money',
                'discount_full',
                'extra_param',
                'count',
                'published',
                'deleted'
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
            'order_id' => Yii::t('shop', 'Order id'),
            'product_id' => Yii::t('shop', 'Product id'),
            'count' => Yii::t('shop', 'Count of item'),
            'summ' => Yii::t('shop', 'Summ without discount for item'),
            'total_summ' => Yii::t('shop', 'Total Summ with discount for item'),
            'discount_percent' => Yii::t('shop', 'Percent discount for item'),
            'discount_money' => Yii::t('shop', 'Discount of money for item'),
            'discount_full' => Yii::t('shop', 'Summ discount for item'),
            'extra_param' => Yii::t('shop', 'Extra param'),
            'created_at' => Yii::t('app', 'Create time'),
            'updated_at' => Yii::t('app', 'Update time'),
            'published' => Yii::t('app', 'Published'),
            'deleted' => Yii::t('app', 'Deleted'),
        ];
    }

}
