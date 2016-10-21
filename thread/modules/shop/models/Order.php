<?php

namespace thread\modules\shop\models;

use Yii;

use thread\app\base\models\ActiveRecord;
use thread\modules\shop\Shop;

/**
 * Class Order
 *
 * @property integer $id
 * @property integer $customer_id
 * @property integer $manager_id
 * @property integer $delivery_method_id
 * @property float $delivery_price
 * @property integer $payment_method_id
 * @property string $order_status
 * @property string $payd_status
 * @property integer $items_count
 * @property integer $items_total_count
 * @property float $items_summ
 * @property float $items_total_summ
 * @property float $discount_percent
 * @property float $discount_money
 * @property float $discount_full
 * @property float $total_summ
 * @property string $comment
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $published
 * @property integer $deleted
 *
 * @property OrderItem[] $items
 *
 * @package thread\modules\shop\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @author Alla Kuzmenko
 * @copyright (c) 2016, VipDesign
 */
class Order extends ActiveRecord
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
        return '{{%shop_order}}';
    }


    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['customer_id', 'delivery_method_id', 'payment_method_id'], 'required'],
            [['comment'], 'string', 'max' => 512],
            [['customer_id', 'items_count', 'items_total_count', 'created_at', 'updated_at'], 'integer'],
            [
                ['items_summ', 'items_total_summ', 'discount_percent', 'discount_money', 'discount_full', 'total_summ'],
                'double'
            ],
            [
                ['items_summ', 'items_total_summ', 'discount_percent', 'discount_money', 'discount_full', 'total_summ'],
                'default',
                'value' => 0.0
            ],
            [['items_total_count', 'items_count'], 'default', 'value' => 0],
            [['delivery_method_id', 'payment_method_id'], 'default', 'value' => 0],
            [['order_status'], 'in', 'range' => array_keys(self::progressRange())],
            [['payd_status'], 'in', 'range' => array_keys(self::paydStatusRange())],
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
            'customer_id' => Yii::t('app', 'customer id'),
            'comment' => Yii::t('app', 'comment'),
            'items_count' => Yii::t('app', 'count of items'),
            'items_total_count' => Yii::t('app', 'summ of item_count'),
            'items_summ' => Yii::t('app', 'Summ of items without discount for item'),
            'items_total_summ' => Yii::t('app', 'Total Summ of items with discount for item'),
            'discount_percent' => Yii::t('app', 'Percent discount for order'),
            'discount_money' => Yii::t('app', 'Discount of money for order'),
            'discount_full' => Yii::t('app', 'Summ discount for order'),
            'total_summ' => Yii::t('app', 'Finish Summ'),
            'order_status' => Yii::t('shop', 'order_status'),
            'payd_status' => Yii::t('shop', 'payd_status'),
            'delivery_method_id' => Yii::t('app', 'delivery_method_id'),
            'payment_method_id' => Yii::t('shop', 'payment_method_id'),
            'delivery_price' => Yii::t('shop', 'delivery_price'),
            'created_at' => Yii::t('app', 'Create time'),
            'updated_at' => Yii::t('app', 'Update time'),
            'published' => Yii::t('app', 'Published'),
            'deleted' => Yii::t('app', 'Deleted'),
        ];
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
    public function getCustomer()
    {
        return $this->hasOne(Customer::class, ['id' => 'customer_id']);
    }

    /**
     * @return mixed
     */
    public function getDeliveryMethod()
    {
        return $this->hasOne(DeliveryMethods::class, ['id' => 'delivery_method_id']);
    }

    /**
     * @return mixed
     */
    public function getPaymentMethod()
    {
        return $this->hasOne(PaymentMethods::class, ['id' => 'payment_method_id']);
    }

    /**
     *
     * @return array
     */
    public static function paydStatusRange()
    {
        return [
            'billed' => Yii::t('shop', 'ps_billed'),
            'not_paid' => Yii::t('shop', 'ps_not_paid'),
            'paid_up' => Yii::t('shop', 'ps_paid_up')
        ];
    }

    /**
     *
     * @return array
     */
    public static function progressRange()
    {
        return [
            'new' => Yii::t('shop', 'p_new'),
            'confirmed' => Yii::t('shop', 'p_confirmed'),
            'on_performance' => Yii::t('shop', 'p_on_performance'),
            'prepared' => Yii::t('shop', 'p_prepared'),
            'on_delivery' => Yii::t('shop', 'p_on_delivery'),
            'refusal' => Yii::t('shop', 'p_refusal'),
            'executed' => Yii::t('shop', 'p_executed')
        ];
    }

}