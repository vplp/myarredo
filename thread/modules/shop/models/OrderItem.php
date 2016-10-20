<?php

namespace thread\modules\shop\models;

use Yii;

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
 * @author FilamentV <vortex.filament@gmail.com>
 * @author Alla Kuzmenko
 * @copyright (c) 2016, VipDesign
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
            [['price', 'summ', 'total_summ','discount_percent', 'discount_money', 'discount_full'], 'double'],
            [['price', 'summ', 'total_summ','discount_percent', 'discount_money', 'discount_full'], 'default', 'value' => 0.0],
            [['extra_param'], 'string'],
            [['count'], 'default', 'value' => 1],
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
            'backend' => ['order_id', 'product_id', 'summ', 'total_summ', 'discount_percent', 'discount_money', 'discount_full','extra_param', 'count',  'published', 'deleted'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'order_id' => Yii::t('app', 'cart id'),
            'product_id' => Yii::t('app', 'product id'),
            'count' => Yii::t('app', 'count of item'),
            'summ' => Yii::t('app', 'Summ without discount for item'),
            'total_summ' => Yii::t('app', 'Total Summ with discount for item'),
            'discount_percent' => Yii::t('app', 'Percent discount for order'),
            'discount_money' => Yii::t('app', 'Discount of money for order'),
            'discount_full' => Yii::t('app', 'Summ discount for order'),
            'extra_param' => Yii::t('app', 'Extra param'),
            'created_at' => Yii::t('app', 'Create time'),
            'updated_at' => Yii::t('app', 'Update time'),
            'published' => Yii::t('app', 'Published'),
            'deleted' => Yii::t('app', 'Deleted'),
        ];
    }


}