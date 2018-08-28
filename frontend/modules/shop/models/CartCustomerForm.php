<?php

namespace frontend\modules\shop\models;

use Yii;
use yii\base\Model;

/**
 * Class CartCustomerForm
 *
 * @property string $full_name
 * @property string $email
 * @property string $phone
 * @property string $comment
 * @property int $user_agreement
 * @property integer $city_id
 *
 * @package frontend\modules\shop\models
 */
Class CartCustomerForm extends Model
{
    public $reCaptcha;
    public $full_name;
    public $email;
    public $phone;
    public $comment;
    public $delivery;
    public $pay;
    public $user_agreement;
    public $city_id;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['full_name', 'email', 'phone', 'reCaptcha', 'city_id'], 'required'],
            [['delivery'], 'in', 'range' => array_keys(DeliveryMethods::dropDownList())],
            [['pay'], 'in', 'range' => array_keys(PaymentMethods::dropDownList())],
            [['comment'], 'string', 'max' => 2048],
            [['full_name'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 50],
            [['email'], 'email'],
            [['delivery', 'pay'], 'default', 'value' => 0],
            [['user_agreement'], 'in', 'range' => [0, 1]],
            [['comment'], 'default', 'value' => ''],
            [['city_id'], 'integer'],
            [
                ['user_agreement'],
                'required',
                'on' => ['frontend'],
                'requiredValue' => 1,
                'message' => Yii::t('app', 'Вы должны ознакомиться и согласиться')
            ],
            [['reCaptcha'], \himiklab\yii2\recaptcha\ReCaptchaValidator::className()]
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
                'comment',
                'delivery',
                'pay',
                'user_agreement',
                'city_id',
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
            'comment' => Yii::t('app', 'Comment'),
            'delivery' => Yii::t('app', 'Delivery method'),
            'pay' => Yii::t('app', 'Payment method'),
            'user_agreement' => Yii::t('app', 'Подтверждаю <a href="/terms-of-use/" target="_blank">пользовательское соглашение</a>'),
            'city_id' => Yii::t('app', 'City'),
        ];
    }
}