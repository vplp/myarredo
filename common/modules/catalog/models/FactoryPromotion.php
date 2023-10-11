<?php

namespace common\modules\catalog\models;

use YandexCheckout\Helpers\Random;
use Yii;
use yii\helpers\{
    ArrayHelper
};
use voskobovich\behaviors\ManyToManyBehavior;
//
use thread\app\base\models\ActiveRecord;
//
use common\modules\catalog\Catalog as CatalogModule;
use common\modules\user\models\User;
use common\modules\location\models\{
    Country, City
};
use common\components\YandexKassaAPI\interfaces\OrderInterface;

/**
 * Class FactoryPromotion
 *
 * @property integer $id
 * @property integer $factory_id
 * @property integer $user_id
 * @property string $invoice_id
 * @property integer $country_id
 * @property integer $views
 * @property double $amount
 * @property double $amount_with_vat
 * @property boolean $status
 * @property string $payment_status
 * @property integer $start_date_promotion
 * @property integer $end_date_promotion
 * @property string $payment_object
 * @property integer $created_at
 * @property integer $updated_at
 * @property boolean $published
 * @property boolean $deleted
 * @property array $city_ids
 * @property array $product_ids
 *
 * @property User $user
 * @property Factory $factory
 * @property Country $country
 * @property FactoryPromotionRelCity[] $cities
 * @property FactoryPromotionRelProduct[] $products
 * @property FactoryPromotionRelProduct[] $italianProducts
 *
 * @package common\modules\catalog\models
 */
class FactoryPromotion extends ActiveRecord
{
    const PAYMENT_STATUS_PENDING = 'pending';
    const PAYMENT_STATUS_ACCEPTED = 'accepted';
    const PAYMENT_STATUS_SUCCESS = 'success';
    const PAYMENT_STATUS_FAIL = 'fail';

    const STATUS_NOT_ACTIVE = 'not_active';
    const STATUS_ACTIVE = 'active';
    const STATUS_COMPLETED = 'completed';

    /**
     * @return mixed|null|object|string|\yii\db\Connection
     * @throws \yii\base\InvalidConfigException
     */
    public static function getDb()
    {
        return CatalogModule::getDb();
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
            [
                [
                    'factory_id',
                    'user_id',
                    'country_id',
                    'views',
                    'created_at',
                    'updated_at'
                ],
                'integer'
            ],
            [
                ['start_date_promotion'],
                'date',
                'format' => 'php:' . CatalogModule::getFormatDate(),
                'timestampAttribute' => 'start_date_promotion'
            ],
            [
                ['end_date_promotion'],
                'date',
                'format' => 'php:' . CatalogModule::getFormatDate(),
                'timestampAttribute' => 'end_date_promotion'
            ],
            [['invoice_id'], 'string', 'max' => 255],
            [['payment_object'], 'string'],
            [['amount', 'amount_with_vat'], 'double'],
            [['published', 'deleted'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [['status'], 'in', 'range' => array_keys(static::statusRange())],
            [['payment_status'], 'in', 'range' => array_keys(static::paymentStatusRange())],
            [['factory_id' => 0, 'amount', 'amount_with_vat', 'views'], 'default', 'value' => '0'],
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
            'setPaymentStatus' => [
                'payment_status',
                'payment_object',
                'start_date_promotion',
                'end_date_promotion'
            ],
            'backend' => [
                'factory_id',
                'user_id',
                'country_id',
                'views',
                'amount',
                'amount_with_vat',
                'status',
                'payment_status',
                'start_date_promotion',
                'end_date_promotion',
                'published',
                'deleted',
            ],
            'frontend' => [
                'factory_id',
                'user_id',
                'country_id',
                'views',
                'amount',
                'amount_with_vat',
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
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'factory_id' => Yii::t('app', 'Factory'),
            'user_id' => Yii::t('app', 'User'),
            'invoice_id',
            'country_id' => Yii::t('app', 'Country'),
            'views' => Yii::t('app', 'Сколько показов Ваших товаров вы хотите получить'),
            'amount' => Yii::t('app', 'Cost'),
            'amount_with_vat' => Yii::t('app', 'Cost with vat'),
            'status' => Yii::t('app', 'Status'),
            'payment_status' => Yii::t('app', 'Payment status'),
            'start_date_promotion' => Yii::t('app', 'Start date promotion'),
            'end_date_promotion' => Yii::t('app', 'End date promotion'),
            'created_at' => Yii::t('app', 'Create time'),
            'updated_at' => Yii::t('app', 'Update time'),
            'published' => Yii::t('app', 'Published'),
            'deleted' => Yii::t('app', 'Deleted'),
            'city_ids' => Yii::t('app', 'Cities'),
            'product_ids' => Yii::t('app', 'Products'),
        ];
    }

    /**
     * @param string $key
     * @return array|mixed
     */
    public static function statusRange($key = '')
    {
        $data = [
            static::STATUS_NOT_ACTIVE => Yii::t('app', 'Not active'),
            static::STATUS_ACTIVE => Yii::t('app', 'Active'),
            static::STATUS_COMPLETED => Yii::t('app', 'Completed'),
        ];

        return $key ? $data[$key] : $data;
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

        if (in_array($this->scenario, ['setPaymentStatus'])) {
            if ($this->payment_status == 'success') {
                $start_date = mktime(date("H"), date("i"), 0, date("m"), date("d"), date("Y"));
                $end_date = mktime(date("H"), date("i"), 0, date("m"), date("d") + 3, date("Y"));

                $this->start_date_promotion = $start_date;
                $this->end_date_promotion = $end_date;
            }
        }

        return parent::beforeSave($insert);
    }

    /**
     * @return string
     */
    public function getStatusTitle()
    {
        return self::statusRange($this->status);
    }

    /**
     * @return string
     */
    public function getPaymentStatusTitle()
    {
        return Yii::t('app', ucfirst($this->payment_status));
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::class, ['id' => 'country_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
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
    public function getUser()
    {
        return $this
            ->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFactory()
    {
        return $this->hasOne(Factory::class, ['id' => 'factory_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getProducts()
    {
        return $this
            ->hasMany(Product::class, ['id' => 'catalog_item_id'])
            ->viaTable(FactoryPromotionRelProduct::tableName(), ['promotion_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getItalianProducts()
    {
        return $this
            ->hasMany(ItalianProduct::class, ['id' => 'catalog_item_id'])
            ->viaTable(FactoryPromotionRelProduct::tableName(), ['promotion_id' => 'id']);
    }

    /**
     * @return mixed
     */
    public static function findBase()
    {
        return self::find()
            ->orderBy(self::tableName() . '.start_date_promotion DESC');
    }

    /**
     * @param int $views
     * @param int $country
     * @return array
     */
    public static function getCountOfViews($views = 0, $country = 0)
    {
        $array = [
            500 => [2 => 10000, 3 => 7500],
            1000 => [2 => 19000, 3 => 14000],
            1500 => [2 => 27000, 3 => 19500],
            2000 => [2 => 34000, 3 => 24000],
            2500 => [2 => 40000, 3 => 27500],
            3000 => [2 => 45000, 3 => 30000],
            3500 => [2 => 49000, 3 => 31500],
            4000 => [2 => 52000, 3 => 42000],
            4500 => [2 => 54000, 3 => 31500],
        ];

        if ($country && $views) {
            return $array[$views][$country];
        }

        return $array;
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
        return $this->amount_with_vat;
    }

    /**
     * @return int|mixed
     */
    public function getEmail()
    {
        return $this->user->email;
    }

    /**
     * @return array|int
     * @throws \Exception
     */
    public function getItems()
    {
        return [
            [
                'description' => 'promotion',
                'quantity' => 1,
                'amount' => [
                    'value' => $this->getPaymentAmount(),
                    'currency' => "RUB",
                ],
                'vat_code' => Random::int(1, 6),
            ]
        ];
    }

    /**
     * @param $invoiceId
     * @return OrderInterface
     */
    public function findByInvoiceId($invoiceId)
    {
        return self::find()->where(['invoice_id' => $invoiceId]);
    }

    /**
     * @return string
     */
    public function getStartDatePromotionTime()
    {
        $format = CatalogModule::getFormatDate();
        return $this->start_date_promotion == 0 ? date($format) : date($format, $this->start_date_promotion);
    }

    /**
     * @return string
     */
    public function getEndDatePromotionTime()
    {
        $format = CatalogModule::getFormatDate();
        return $this->end_date_promotion == 0 ? date($format) : date($format, $this->end_date_promotion);
    }
}
