<?php

namespace common\modules\shop\models;

use yii\helpers\ArrayHelper;

/**
 * Class Order
 *
 * @package common\modules\shop\models
 */
class Order extends \thread\modules\shop\models\Order
{
    /**
     * @return mixed
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [

        ]);
    }

    /**
     * @return mixed
     */
    public function scenarios()
    {
        return ArrayHelper::merge(parent::scenarios(), [
            'backend' => [

            ],
        ]);
    }

    /**
     * @return mixed
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(),
            [

            ]
        );
    }

    /**
     * @return mixed
     */
    public static function findBase()
    {
        return self::find()->orderBy(['created_at' => SORT_DESC]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customer::class, ['id' => 'customer_id']);
    }
}