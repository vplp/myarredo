<?php

namespace common\modules\catalog\models;

use common\modules\location\models\City;
use Yii;
use yii\helpers\{
    ArrayHelper
};
use voskobovich\behaviors\ManyToManyBehavior;
//
use thread\app\base\models\ActiveRecord;
//
use common\modules\catalog\Catalog;
use common\components\YandexKassaAPI\interfaces\OrderInterface;

/**
 * Class FactoryPromotion
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $invoice_id
 * @property integer $country_id
 * @property integer $views
 * @property double $amount
 * @property boolean $status
 * @property string $payment_status
 * @property string $payment_object
 * @property integer $created_at
 * @property integer $updated_at
 * @property boolean $published
 * @property boolean $deleted
 * @property array $city_ids
 * @property array $product_ids
 *
 * @property FactoryPromotionRelCity[] $cities
 * @property FactoryPromotionRelProduct[] $products
 *
 * @package common\modules\catalog\models
 */
class FactoryPromotion extends ActiveRecord implements OrderInterface
{
    const PAYMENT_STATUS_NEW = 'new';
    const PAYMENT_STATUS_PAID = 'paid';

    /**
     * @return string
     */
    public static function getDb()
    {
        return Catalog::getDb();
    }

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%catalog_factory_promotion}}';
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
                    'city_ids' => 'cities',
                ],
            ],
            [
                'class' => ManyToManyBehavior::className(),
                'relations' => [
                    'product_ids' => 'products',
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
            [['user_id', 'views'], 'required'],
            [['user_id', 'country_id', 'views', 'created_at', 'updated_at'], 'integer'],
            [['invoice_id'], 'string', 'max' => 255],
            [['payment_object'], 'string'],
            [['amount'], 'double'],
            [['status', 'published', 'deleted'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [['payment_status'], 'in', 'range' => array_keys(static::paymentStatusKeyRange())],
            [['amount', 'views'], 'default', 'value' => '0'],
            [['payment_object'], 'default', 'value' => ''],
            [['city_ids', 'product_ids'], 'each', 'rule' => ['integer']],
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
            'setInvoiceId' => ['invoice_id'],
            'setPaymentStatus' => ['payment_status', 'payment_object'],
            'backend' => [
                'user_id',
                'country_id',
                'views',
                'amount',
                'status',
                'published',
                'deleted',
            ],
            'frontend' => [
                'user_id',
                'country_id',
                'views',
                'amount',
                'status',
                'published',
                'deleted',
                'city_ids',
                'product_ids'
            ],
        ];
    }

    /**
     * @return array
     */
    public static function paymentStatusKeyRange()
    {
        return [
            static::PAYMENT_STATUS_NEW => static::PAYMENT_STATUS_NEW,
            static::PAYMENT_STATUS_PAID => static::PAYMENT_STATUS_PAID
        ];
    }

    /**
     * @return bool
     */
    public function beforeValidate()
    {
        if (in_array($this->scenario, ['frontend'])) {
            $cities = [];
            foreach ($this->city_ids as $country) {
                if ($country) {
                    $cities = ArrayHelper::merge($cities, $country);
                }
            }

            $this->city_ids = $cities;
        }

        return parent::beforeValidate();
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (in_array($this->scenario, ['frontend'])) {
            if ($this->product_ids && $this->id) {
                FactoryPromotionRelProduct::deleteAll('promotion_id = :id', [':id' => $this->id]);
            }
        }

        return parent::beforeSave($insert);
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User'),
            'invoice_id',
            'country_id' => Yii::t('app', 'Country'),
            'views' => Yii::t('app', 'Сколько показов Ваших товаров вы хотите получить'),
            'amount' => Yii::t('app', 'Cost'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Create time'),
            'updated_at' => Yii::t('app', 'Update time'),
            'published' => Yii::t('app', 'Published'),
            'deleted' => Yii::t('app', 'Deleted'),
            'city_ids' => Yii::t('app', 'Cities'),
            'product_ids' => Yii::t('app', 'Products'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCities()
    {
        return $this
            ->hasMany(City::class, ['id' => 'city_id'])
            ->viaTable(FactoryPromotionRelCity::tableName(), ['promotion_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this
            ->hasMany(Product::class, ['id' => 'catalog_item_id'])
            ->viaTable(FactoryPromotionRelProduct::tableName(), ['promotion_id' => 'id']);
    }

    /**
     * @return mixed
     */
    public static function findBase()
    {
        return self::find()
            ->orderBy(self::tableName() . '.updated_at DESC');
    }

    /**
     * @return array
     */
    public static function getCountOfViews()
    {
        return [
            1000 => [2 => 24000, 3 => 20400],
            1400 => [2 => 32000, 3 => 27200],
            1900 => [2 => 40000, 3 => 34000],
            2500 => [2 => 48000, 3 => 40800],
            3100 => [2 => 56000, 3 => 47600],
            3600 => [2 => 64000, 3 => 54400],
            4200 => [2 => 72000, 3 => 61200],
            5000 => [2 => 80000, 3 => 68000],
        ];
    }

    /**
     * @param string $invoiceId
     */
    public function setInvoiceId($invoiceId)
    {
        $this->setScenario('setInvoiceId');

        $this->invoice_id = $invoiceId;
    }

    /**
     * @return mixed|string
     */
    public function getInvoiceId()
    {
        return $this->invoice_id;
    }

    /**
     * @return int|mixed
     */
    public function getPaymentAmount()
    {
        return $this->amount;
    }

    /**
     * @param $invoiceId
     * @return OrderInterface
     */
    public function findByInvoiceId($invoiceId)
    {
        return self::find()->where(['invoice_id' => $invoiceId]);
    }
}