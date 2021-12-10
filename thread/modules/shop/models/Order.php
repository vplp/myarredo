<?php

namespace thread\modules\shop\models;

use Yii;
use DateTime;
use thread\app\base\models\ActiveRecord;
use thread\modules\shop\Shop;
use thread\modules\shop\models\query\OrderQuery;

/**
 * Class Order
 *
 * @property integer $id
 * @property integer $customer_id
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
 * @property string $order_first_url_visit
 * @property integer $order_count_url_visit
 * @property string $token
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $published
 * @property integer $deleted
 *
 * @property OrderItem[] $items
 *
 * @package thread\modules\shop\models
 */
class Order extends ActiveRecord
{
    /**
     * @var string
     */
    public static $commonQuery = OrderQuery::class;

    /**
     * @return null|object
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
            [['order_first_url_visit'], 'string'],
            [['token'], 'string', 'max' => 255],
            [['customer_id', 'items_count', 'items_total_count', 'created_at', 'updated_at', 'order_count_url_visit'], 'integer'],
            [
                [
                    'items_summ',
                    'items_total_summ',
                    'discount_percent',
                    'discount_money',
                    'discount_full',
                    'total_summ'
                ],
                'double'
            ],
            [['order_status'], 'in', 'range' => array_keys(self::getOrderStatuses())],
            [['payd_status'], 'in', 'range' => array_keys(self::getPaidStatuses())],
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
                'order_first_url_visit',
                'order_count_url_visit',
                'items_summ',
                'items_total_summ',
                'discount_percent',
                'discount_money',
                'discount_full',
                'total_summ',
                'customer_id',
                'items_count',
                'items_total_count',
                'token',
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
            'customer_id' => Yii::t('shop', 'Customer'),
            'comment' => Yii::t('app', 'Comment'),
            'items_count' => Yii::t('shop', 'Count of items'),
            'items_total_count' => Yii::t('shop', 'Summ of items count'),
            'items_summ' => Yii::t('shop', 'Summ of items without discount for item'),
            'items_total_summ' => Yii::t('shop', 'Total Summ of items with discount for item'),
            'discount_percent' => Yii::t('shop', 'Percent discount for order'),
            'discount_money' => Yii::t('shop', 'Discount of money for order'),
            'discount_full' => Yii::t('shop', 'Summ discount for order'),
            'total_summ' => Yii::t('shop', 'Finish Summ'),
            'order_status' => Yii::t('shop', 'Order status'),
            'payd_status' => Yii::t('shop', 'Payd status'),
            'delivery_method_id' => Yii::t('shop', 'Delivery method'),
            'payment_method_id' => Yii::t('shop', 'Payment method'),
            'delivery_price' => Yii::t('shop', 'Delivery price'),
            'token' => Yii::t('shop', 'Token'),
            'created_at' => Yii::t('app', 'Create time'),
            'updated_at' => Yii::t('app', 'Update time'),
            'published' => Yii::t('app', 'Published'),
            'deleted' => Yii::t('app', 'Deleted'),
            'order_first_url_visit' => 'order_first_url_visit',
            'order_count_url_visit' => 'order_count_url_visit',
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
     * @return array
     */
    public static function getPaidStatuses()
    {
        return [
            'billed' => Yii::t('shop', 'Billed'),
            'not_paid' => Yii::t('shop', 'Not paid'),
            'paid_up' => Yii::t('shop', 'Paid up')
        ];
    }

    /**
     * @param string $key
     * @return array|mixed
     */
    public static function getOrderStatuses($key = '')
    {
        $data = [
            'new' => Yii::t('shop', 'Order_status_new'),
            'in_work' => Yii::t('shop', 'Order_status_in_work'),
            'given_to_salon' => Yii::t('shop', 'Order_status_given_to_salon'),
            'contract_signed' => Yii::t('shop', 'Order_status_contract_signed'),
            'failure' => Yii::t('shop', 'Order_status_failure'),
            'archive' => Yii::t('shop', 'Order_status_archive'),
            'postpone' => Yii::t('shop', 'Order_status_postpone'),
        ];

        if ($key && $data[$key]) {
            return $data[$key];
        } else {
            return $data;
        }
    }

    /**
     * Generates new token
     */
    public function generateToken()
    {
        $this->token = Yii::$app->getSecurity()->generateRandomString() . '_' . time();
        return $this;
    }

    /**
     * @return string
     */
    public function getCreatedTime()
    {
        $format = 'd.m.Y H:i';
        return $this->created_at == 0 ? date($format) : date($format, $this->created_at);
    }

    /**
     * @return string
     */
    public function getAnswerTime($role = '')
    {
        foreach ($this->orderAnswers as $key => $answer) {
            if ($answer->user->group->role == $role) {
                return $answer->getAnswerTime();
            }
        }
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function getDiffAnswerTime($role = '')
    {
        $datetime1 = (new DateTime())->setTimestamp($this->created_at);

        $datetime2 = new DateTime('now');

        foreach ($this->orderAnswers as $key => $answer) {
            if ($answer->user->group->role == $role) {
                $datetime2 = (new DateTime())->setTimestamp($answer->answer_time);
            }
        }

        $interval = $datetime1->diff($datetime2);
        return $interval->format('%h');
    }
}
