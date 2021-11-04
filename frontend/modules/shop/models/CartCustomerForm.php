<?php

namespace frontend\modules\shop\models;

use Yii;
use yii\base\Model;
use frontend\modules\location\models\Country;

/**
 * Class CartCustomerForm
 *
 * @property string $full_name
 * @property string $email
 * @property string $phone
 * @property string $city_name
 * @property string $comment
 * @property int $user_agreement
 * @property integer $country_code
 * @property integer $city_id
 *
 * @property Country $country
 *
 * @package frontend\modules\shop\models
 */
class CartCustomerForm extends Model
{
    public $reCaptcha;
    public $full_name;
    public $email;
    public $phone;
    public $city_name;
    public $comment;
    public $delivery;
    public $pay;
    public $user_agreement;

    public $image_link;

    public $country_code;
    public $city_id;

    /**
     * @return array
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public function rules()
    {
        return [
            [['full_name', 'email', 'phone', 'reCaptcha', 'country_code'], 'required'],
            [['comment'], 'string', 'max' => 2048],
            [['full_name', 'city_name'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 50],
            [['email'], 'email'],
            [['user_agreement'], 'in', 'range' => [0, 1]],
            [['comment'], 'default', 'value' => ''],
            [['city_id'], 'integer'],
            [['delivery', 'pay', 'city_id'], 'default', 'value' => 0],
            [['country_code'], 'in', 'range' => array_keys(Country::dropDownList([], 'alias', 'alias'))],
            [
                ['user_agreement'],
                'required',
                'on' => ['frontend'],
                'requiredValue' => 1,
                'message' => Yii::t('app', 'Вы должны ознакомиться и согласиться')
            ],
            [['image_link'], 'string', 'max' => 255],
            ['image_link', 'file', 'extensions' => ['png', 'jpg'], 'maxSize' => 1024 * 500],
            [['reCaptcha'], \himiklab\yii2\recaptcha\ReCaptchaValidator2::class]
        ];
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return [
            'frontend' => [
                'full_name',
                'email',
                'phone',
                'city_name',
                'comment',
                'delivery',
                'pay',
                'user_agreement',
                'city_id',
                'country_code',
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
            'full_name' => Yii::t('app', 'Name'),
            'email' => Yii::t('app', 'Email'),
            'phone' => Yii::t('app', 'Phone'),
            'city_name' => Yii::t('app', 'City'),
            'comment' => Yii::t('app', 'Comment'),
            'delivery' => Yii::t('app', 'Delivery method'),
            'pay' => Yii::t('app', 'Payment method'),
            'user_agreement' => Yii::t('app', 'Подтверждаю <a href="/terms-of-use/" target="_blank">пользовательское соглашение</a>'),
            'country_code' => Yii::t('app', 'Country'),
            'city_id' => Yii::t('app', 'City'),
            'image_link' => Yii::t('app', 'Image link'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return Country::findOne(['alias' => $this->country_code]);
    }
}
