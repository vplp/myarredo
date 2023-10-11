<?php

namespace common\modules\payment\models;

use Yii;
use yii\helpers\{
    ArrayHelper
};
//
use voskobovich\behaviors\ManyToManyBehavior;
//
use common\modules\payment\PaymentModule;
use common\modules\promotion\models\PromotionPackage;
use common\modules\catalog\models\{
    Product, Sale, ItalianProduct, FactoryPromotion
};
//
use thread\app\base\models\ActiveRecord;

/**
 * Class Payment
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $type
 * @property string $tariffs
 * @property integer $promotion_package_id
 * @property boolean $change_tariff
 * @property integer $amount
 * @property string $currency
 * @property string $payment_status
 * @property integer $payment_time
 * @property integer $created_at
 * @property integer $updated_at
 * @property boolean $published
 * @property boolean $deleted
 *
 * @property array $items_ids
 *
 * @property PromotionPackage $promotionPackage
 * @property PaymentRelItem[] $items
 *
 * @package common\modules\payment\models
 */
class Payment extends ActiveRecord
{
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
     * @return bool
     */
    public function beforeValidate()
    {
        if (is_array($this->items_ids) == false) {
            $this->items_ids = [$this->items_ids];
        }

        return parent::beforeValidate();
    }

    /**
     * @inheritDoc
     */
    public function beforeSave($insert)
    {
        if (is_array($this->tariffs) && !empty($this->tariffs)) {
            $this->tariffs = implode('; ', $this->tariffs);
        } else {
            $this->tariffs = '';
        }

        return parent::beforeSave($insert);
    }

    /**
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        /**
         * if change_tariff = 1 change create_mode
         */
        if (isset($changedAttributes['payment_status']) &&
            $this->payment_status == self::PAYMENT_STATUS_SUCCESS &&
            $this->type == 'italian_item' &&
            $this->change_tariff == 1) {
            foreach ($this->items as $item) {
                /** @var $item ItalianProduct */
                $item->setScenario('create_mode');
                $item->create_mode = 'paid' ? 'free' : 'paid';
                $item->save();
            }
        }
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
            [['payment_status'], 'in', 'range' => array_keys(static::paymentStatusRange())],
            [['amount'], 'double', 'min' => 1],
            [
                ['payment_time'],
                'date',
                'format' => 'php:d.m.Y H:i',
                'timestampAttribute' => 'payment_time'
            ],
            [['user_id', 'promotion_package_id', 'create_time', 'update_time'], 'integer'],
            [['change_tariff', 'published', 'deleted'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [['promotion_package_id', 'change_tariff'], 'default', 'value' => 0],
            [
                'items_ids',
                'each',
                'rule' => ['integer']
            ],
            [['tariffs'], 'each', 'rule' => ['string']],
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
                'tariffs',
                'promotion_package_id',
                'change_tariff',
                'amount',
                'currency',
                'payment_status',
                'payment_time',
                'published',
                'items_ids'
            ],
            'frontend' => [
                'user_id',
                'type',
                'tariffs',
                'promotion_package_id',
                'change_tariff',
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
            'user_id' => Yii::t('app', 'User'),
            'type' => Yii::t('app', 'Payment type'),
            'tariffs' => Yii::t('app', 'Тарифы'),
            'promotion_package_id' => Yii::t('app', 'Promotion package'),
            'change_tariff' => Yii::t('app', 'Смена тарифа'),
            'amount' => Yii::t('app', 'Amount'),
            'currency' => Yii::t('app', 'Currency'),
            'payment_status' => Yii::t('app', 'Payment status'),
            'payment_time' => Yii::t('app', 'Payment time'),
            'created_at' => Yii::t('app', 'Create time'),
            'updated_at' => Yii::t('app', 'Update time'),
            'published' => Yii::t('app', 'Published'),
            'deleted' => Yii::t('app', 'Deleted'),
            'items_ids' => Yii::t('app', 'Products'),
        ];
    }

    /**
     * @return mixed
     */
    public static function findBase()
    {
        return self::find()->orderBy('id DESC');
    }

    /**
     * @return string
     */
    public function getInvDesc()
    {
        $desc = '';

        if ($this->type == 'factory_promotion') {
            $desc = Yii::t('app', 'Оплата рекламной кампании');
        } elseif ($this->type == 'italian_item') {
            $desc = Yii::t('app', 'Оплата товаров');
        } elseif ($this->type == 'italian_item_delivery') {
            $desc = Yii::t('app', 'Оплата заявки на доставку');
        } elseif ($this->type == 'promotion_item') {
            $desc = 'promotion_item';
        } elseif ($this->type == 'promotion_sale_item') {
            $desc = 'promotion_sale_item';
        } elseif ($this->type == 'promotion_italian_item') {
            $desc = 'promotion_italian_item';
        } elseif ($this->type == 'tariffs') {
            $desc = Yii::t('app', 'Тарифы');
        }

        return $desc;
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getItems()
    {
        $class = FactoryPromotion::class;

        if ($this->type == 'factory_promotion') {
            $class = FactoryPromotion::class;
        } elseif ($this->type == 'italian_item') {
            $class = ItalianProduct::class;
        } elseif ($this->type == 'italian_item_delivery') {
            $class = ItalianProduct::class;
        } elseif ($this->type == 'promotion_item') {
            $class = Product::class;
        } elseif ($this->type == 'promotion_sale_item') {
            $class = Sale::class;
        } elseif ($this->type == 'promotion_italian_item') {
            $class = ItalianProduct::class;
        }

        return $this
            ->hasMany($class, ['id' => 'item_id'])
            ->viaTable(PaymentRelItem::tableName(), ['payment_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPromotionPackage()
    {
        return $this->hasOne(PromotionPackage::class, ['id' => 'promotion_package_id']);
    }

    /**
     * @param string $key
     * @return array|mixed
     */
    public static function paymentStatusRange($key = '')
    {
        $data = [
            static::PAYMENT_STATUS_PENDING => Yii::t('app', 'Pending'),
            static::PAYMENT_STATUS_ACCEPTED => Yii::t('app', 'Accepted'),
            static::PAYMENT_STATUS_SUCCESS => Yii::t('app', 'Success'),
            static::PAYMENT_STATUS_FAIL => Yii::t('app', 'Fail'),
        ];

        return $key ? $data[$key] : $data;
    }

    /**
     * @return array
     */
    public static function getCurrencyKeyRange()
    {
        return [
            'EUR' => 'EUR',
            'RUB' => 'RUB',
            'USD' => 'USD',
        ];
    }

    /**
     * @return array
     */
    public static function getTypeKeyRange()
    {
        return [
            'factory_promotion' => Yii::t('app', 'Оплата рекламной кампании'),
            'italian_item' => Yii::t('app', 'Оплата товаров'),
            'italian_item_delivery' => Yii::t('app', 'Оплата заявки на доставку'),
            'promotion_item' => 'promotion_item',
            'promotion_sale_item' => 'promotion_item',
            'promotion_italian_item' => 'promotion_italian_item',
            'tariffs' => Yii::t('app', 'Тарифы'),
        ];
    }
}
