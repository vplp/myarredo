<?php

namespace frontend\modules\shop\models;

use Yii;

/**
 * Class CartCustomerForm
 *
 * @package frontend\modules\shop\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
Class CartCustomerForm extends \yii\base\Model
{

    public $full_name, $email, $phone, $comment, $delivery, $pay;

    /**
     *
     * @return array
     */
    public function rules()
    {
        return [
            [['full_name', 'email', 'phone', 'delivery', 'pay'], 'required'],
            [['delivery'], 'in', 'range' => array_keys(DeliveryMethods::dropDownList())],
            [['pay'], 'in', 'range' => array_keys(PaymentMethods::dropDownList())],
            [['comment'], 'string', 'max' => 2048],
            [['full_name'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 15],
            [['email'], 'email'],
            [['delivery'], 'default', 'value' => array_keys(DeliveryMethods::dropDownList())[0]],

        ];
    }

    /**
     *
     * @return array
     */
    public function scenarios()
    {
        return [
            'frontend' => ['full_name', 'email', 'phone', 'comment', 'delivery', 'pay', 'agreement'],
        ];
    }

    /**
     *
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'full_name' => Yii::t('app', 'Full name'),
            'email' => Yii::t('app', 'Email'),
            'phone' => Yii::t('app', 'Phone'),
            'comment' => Yii::t('app', 'Comment'),
            'delivery' => Yii::t('app', 'Delivery'),
            'pay' => Yii::t('app', 'Pay')
        ];
    }


}
