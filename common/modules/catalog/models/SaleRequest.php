<?php

namespace common\modules\catalog\models;

use Yii;
//
use thread\app\base\models\ActiveRecord;
//
use common\modules\catalog\Catalog;

/**
 * Class SaleRequest
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $sale_item_id
 * @property integer $country_id
 * @property integer $city_id
 * @property float $offer_price
 * @property string $ip
 * @property string $email
 * @property string $user_name
 * @property string $phone
 * @property string $question
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @package common\modules\catalog\models
 */
class SaleRequest extends ActiveRecord
{
    public $user_agreement;
    public $reCaptcha;
    public $reCaptcha2;

    /**
     * @return object|string|\yii\db\Connection|null
     * @throws \yii\base\InvalidConfigException
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
        return '{{%catalog_sale_item_request}}';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return parent::behaviors();
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [
                ['sale_item_id', 'full_name', 'email', 'phone', 'user_agreement', 'reCaptcha'],
                'required',
                'on' => 'requestForm'
            ],
            [
                ['sale_item_id', 'full_name', 'phone', 'offer_price', 'reCaptcha2'],
                'required',
                'on' => 'offerPriceForm'
            ],
            [['ip'], 'string', 'max' => 45],
            [['question'], 'string', 'max' => 1024],
            [['email', 'user_name', 'phone'], 'string', 'max' => 255],
            [
                [
                    'user_id',
                    'sale_item_id',
                    'country_id',
                    'city_id',
                    'create_time',
                    'update_time',
                ],
                'integer'
            ],
            [['email', 'question'], 'default', 'value' => ''],
            ['offer_price', 'default', 'value' => 0.00],
            [['user_agreement'], 'in', 'range' => [0, 1]],
            [
                ['user_agreement'],
                'required',
                'on' => ['requestForm'],
                'requiredValue' => 1,
                'message' => Yii::t('app', 'Вы должны ознакомиться и согласиться')
            ],
            [['reCaptcha'], \himiklab\yii2\recaptcha\ReCaptchaValidator2::class],
            [['reCaptcha2'], \himiklab\yii2\recaptcha\ReCaptchaValidator2::class]
        ];
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return [
            'requestForm' => [
                'user_id',
                'sale_item_id',
                'country_id',
                'city_id',
                'offer_price',
                'ip',
                'email',
                'user_name',
                'phone',
                'question',
                'user_agreement',
                'reCaptcha'
            ],
            'offerPriceForm' => [
                'user_id',
                'sale_item_id',
                'country_id',
                'city_id',
                'offer_price',
                'ip',
                'email',
                'user_name',
                'phone',
                'question',
                'user_agreement',
                'reCaptcha2'
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
            'sale_item_id' => Yii::t('app', 'Product'),
            'country_id',
            'city_id',
            'offer_price' => Yii::t('app', 'Price'),
            'ip',
            'email' => Yii::t('app', 'Email'),
            'user_name' => Yii::t('app', 'Name'),
            'phone' => Yii::t('app', 'Phone'),
            'question' => Yii::t('app', 'Comment'),
            'created_at' => Yii::t('app', 'Create time'),
            'updated_at' => Yii::t('app', 'Update time'),
            'user_agreement' => Yii::t('app', 'Подтверждаю <a href="/terms-of-use/" target="_blank">пользовательское соглашение</a>'),
            'reCaptcha' => 'Captcha',
            'reCaptcha2' => 'Captcha',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSale()
    {
        return $this->hasOne(Sale::class, ['id' => 'sale_item_id']);
    }

    /**
     * @return mixed
     */
    public static function findBase()
    {
        return self::find();
    }
}
