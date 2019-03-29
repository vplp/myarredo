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

    /**
     * @return null|object|string
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
            [['sale_item_id', 'full_name', 'email', 'phone', 'user_agreement', 'reCaptcha'], 'required'],
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
            [['user_agreement'], 'in', 'range' => [0, 1]],
            [
                ['user_agreement'],
                'required',
                'on' => ['frontend'],
                'requiredValue' => 1,
                'message' => Yii::t('app', 'Вы должны ознакомиться и согласиться')
            ],
            [['reCaptcha'], \frontend\widgets\recaptcha3\RecaptchaV3Validator::className(), 'acceptance_score' => 0.5]
        ];
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return [
            'frontend' => [
                'user_id',
                'sale_item_id',
                'country_id',
                'city_id',
                'ip',
                'email',
                'user_name',
                'phone',
                'question',
                'user_agreement',
                'reCaptcha'
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
            'ip',
            'email' => Yii::t('app', 'Email'),
            'user_name' => Yii::t('app', 'Name'),
            'phone' => Yii::t('app', 'Phone'),
            'question' => Yii::t('app', 'Comment'),
            'created_at' => Yii::t('app', 'Create time'),
            'updated_at' => Yii::t('app', 'Update time'),
            'user_agreement' => Yii::t('app', 'Подтверждаю <a href="/terms-of-use/" target="_blank">пользовательское соглашение</a>'),
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