<?php

namespace common\modules\payment\models;

use Yii;
use yii\helpers\{
    ArrayHelper, Inflector
};
//
use voskobovich\behaviors\ManyToManyBehavior;
//
use common\modules\payment\PaymentModule;
use common\modules\catalog\models\{
    ItalianProduct, FactoryPromotion
};
//
use thread\app\base\models\ActiveRecord;

/**
 * Class Payment
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $type
 * @property integer $amount
 * @property string $currency
 * @property string $payment_status
 * @property integer $payment_time
 * @property integer $created_at
 * @property integer $updated_at
 * @property boolean $published
 * @property boolean $deleted
 *
 * @package common\modules\payment\models
 */
class Payment extends ActiveRecord
{
    public $items_ids;

    const PAYMENT_STATUS_PENDING = 'pending';
    const PAYMENT_STATUS_ACCEPTED = 'accepted';
    const PAYMENT_STATUS_SUCCESS = 'success';
    const PAYMENT_STATUS_FAIL = 'fail';


    /**
     * @return object|string|\yii\db\Connection|null
     * @throws \yii\base\InvalidConfigException
     */
    public static function getDb()
    {
        return PaymentModule::getDb();
    }

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%payment}}';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            [
                'class' => ManyToManyBehavior::className(),
                'relations' => [
                    'items_ids' => 'items',
                ],
            ],
        ]);
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['type', 'amount', 'currency'], 'required'],
            [['type'], 'in', 'range' => array_keys(static::getTypeKeyRange())],
            [['currency'], 'in', 'range' => array_keys(static::getCurrencyKeyRange())],
            [['payment_status'], 'in', 'range' => array_keys(static::getPaymentStatusKeyRange())],
            [['amount'], 'double'],
            [['user_id', 'payment_time', 'create_time', 'update_time'], 'integer'],
            [['published', 'deleted'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [
                [
                    'items_ids',
                ],
                'each',
                'rule' => ['integer']
            ],
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
            'setPaymentStatus' => [
                'payment_status',
                'payment_time',
            ],
            'backend' => [
                'user_id',
                'type',
                'amount',
                'currency',
                'payment_status',
                'payment_time',
                'published',
            ],
            'frontend' => [
                'user_id',
                'type',
                'amount',
                'currency',
                'payment_status',
                'payment_time',
                'items_ids'
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
            'user_id',
            'type',
            'amount',
            'currency',
            'payment_status',
            'payment_time',
            'created_at' => Yii::t('app', 'Create time'),
            'updated_at' => Yii::t('app', 'Update time'),
            'published' => Yii::t('app', 'Published'),
            'deleted' => Yii::t('app', 'Deleted'),
            'items_ids'
        ];
    }

    /**
     * @return mixed
     */
    public static function findBase()
    {
        return self::find()->orderBy('id');
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getItems()
    {
        $class = ($this->type == 'factory_promotion')
            ? FactoryPromotion::class
            : ItalianProduct::class;

        return $this
            ->hasMany($class, ['id' => 'item_id'])
            ->viaTable(PaymentRelItem::tableName(), ['payment_id' => 'id']);
    }

    /**
     * @return array
     */
    public static function getPaymentStatusKeyRange()
    {
        return [
            static::PAYMENT_STATUS_PENDING => 'pending',
            static::PAYMENT_STATUS_ACCEPTED => 'accepted',
            static::PAYMENT_STATUS_SUCCESS => 'success',
            static::PAYMENT_STATUS_FAIL => 'fail',
        ];
    }

    /**
     * @return array
     */
    public static function getCurrencyKeyRange()
    {
        return [
            'EUR' => 'EUR',
            'RUR' => 'RUR',
            'USD' => 'USD',
        ];
    }

    /**
     * @return array
     */
    public static function getTypeKeyRange()
    {
        return [
            'factory_promotion' => 'factory_promotion',
            'italian_item' => 'italian_item'
        ];
    }
}
