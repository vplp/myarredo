<?php

namespace common\modules\shop\models;

use common\modules\shop\Shop;
use common\modules\user\models\User;
use thread\app\base\models\ActiveRecord;

/**
 * Class OrderRelUserForAnswer
 *
 * @property int $order_id
 * @property int $user_id
 *
 * @package common\modules\shop\models
 */
class OrderRelUserForAnswer extends ActiveRecord
{
    /**
     * @return \yii\db\Connection
     */
    public static function getDb()
    {
        return Shop::getDb();
    }

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%shop_order_rel_user_for_answer}}';
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
            ['order_id', 'exist', 'targetClass' => Order::class, 'targetAttribute' => 'id'],
            ['user_id', 'exist', 'targetClass' => User::class, 'targetAttribute' => 'id'],
        ];
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return [
            'backend' => [
                'order_id',
                'user_id',
            ],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'order_id',
            'user_id',
        ];
    }
}
