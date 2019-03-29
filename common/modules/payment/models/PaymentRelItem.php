<?php

namespace common\modules\payment\models;

use common\modules\payment\PaymentModule;
use common\modules\catalog\models\{
    ItalianProduct, FactoryPromotion
};
//
use thread\app\base\models\ActiveRecord;

/**
 * Class PaymentRelItem
 *
 * @property int $payment_id
 * @property int $item_id
 *
 * @package common\modules\payment\models
 */
class PaymentRelItem extends ActiveRecord
{
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
        return '{{%payment_rel_item}}';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [];
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [
                'payment_id',
                'exist',
                'targetClass' => Payment::class,
                'targetAttribute' => 'id'
            ],
            [
                'item_id',
                'exist',
                'targetClass' => [ItalianProduct::class, FactoryPromotion::class],
                'targetAttribute' => 'id'
            ],
        ];
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return [
            'backend' => [
                'payment_id',
                'item_id',
            ],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'payment_id',
            'item_id',
        ];
    }
}
