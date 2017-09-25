<?php

namespace frontend\modules\shop\models;

use Yii;
use yii\base\Model;

/**
 * Class CartCustomerForm
 *
 * @package frontend\modules\shop\models
 */
Class CartCustomerForm extends Model
{
    public $full_name;
    public $email;
    public $phone;
    public $comment;
    public $delivery;
    public $pay;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['full_name', 'email', 'phone'], 'required'],
            [['delivery'], 'in', 'range' => array_keys(DeliveryMethods::dropDownList())],
            [['pay'], 'in', 'range' => array_keys(PaymentMethods::dropDownList())],
            [['comment'], 'string', 'max' => 2048],
            [['full_name'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 15],
            [['email'], 'email'],
            [['delivery', 'pay'], 'default', 'value' => 0],
            [['comment'], 'default', 'value' => ''],
        ];
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return [
            'frontend' => ['full_name', 'email', 'phone', 'comment', 'delivery', 'pay'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'full_name' => Yii::t('app', 'Full name'),
            'email' => Yii::t('app', 'Email'),
            'phone' => Yii::t('app', 'Phone'),
            'comment' => Yii::t('app', 'Comment'),
            'delivery' => Yii::t('app', 'Delivery method'),
            'pay' => Yii::t('app', 'Payment method')
        ];
    }
}