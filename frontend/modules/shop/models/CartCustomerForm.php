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

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['full_name', 'email', 'phone', 'reCaptcha'], 'required'],
            [['delivery'], 'in', 'range' => array_keys(DeliveryMethods::dropDownList())],
            [['pay'], 'in', 'range' => array_keys(PaymentMethods::dropDownList())],
            [['comment'], 'string', 'max' => 2048],
            [['full_name'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 15],
            [['email'], 'email'],
            [['delivery', 'pay'], 'default', 'value' => 0],
            [['user_agreement'], 'in', 'range' => [0, 1]],
            [['comment'], 'default', 'value' => ''],
            [
                ['user_agreement'],
                'required',
                'on' => ['frontend'],
                'requiredValue' => 1,
                'message' => 'Вы должны ознакомиться и согласиться'
            ],
            [
                ['reCaptcha'],
                \himiklab\yii2\recaptcha\ReCaptchaValidator::className(),
                'secret' => '_reCaptcha_SECRET',
                'uncheckedMessage' => 'Please confirm that you are not a bot.'
            ]
        ];
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return [
            'frontend' => ['full_name', 'email', 'phone', 'comment', 'delivery', 'pay', 'user_agreement', 'reCaptcha'],
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
            'user_agreement' => 'Подтверждаю <a href="/terms-of-use/" target="_blank">пользовательское соглашение</a>',
        ];
    }
}