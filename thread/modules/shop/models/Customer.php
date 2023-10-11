<?php

namespace thread\modules\shop\models;

use Yii;
use thread\app\base\models\ActiveRecord;
use thread\modules\shop\Shop;

/**
 * Class Customer
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $email
 * @property string $phone
 * @property string $full_name
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $published
 * @property integer $deleted
 *
 * @property Order[] $orders
 *
 * @package thread\modules\shop\models
 */
class Customer extends ActiveRecord
{
    /**
     * @return string
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
        return '{{%shop_customer}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['phone', 'full_name'], 'required'],
            [['user_id'], 'default', 'value' => 0],
            [['email', 'full_name'], 'string', 'max' => 255],
            [['email'], 'email'],
            [['phone'], 'string', 'max' => 50],
            [['user_id', 'created_at', 'updated_at'], 'integer'],
            [['published', 'deleted'], 'in', 'range' => array_keys(self::statusKeyRange())],
        ];
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return [
            'published' => ['published'],
            'deleted' => ['deleted'],
            'backend' => [
                'user_id',
                'email',
                'phone',
                'full_name',
                'published',
                'deleted'
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
            'email' => Yii::t('app', 'Email'),
            'phone' => Yii::t('app', 'Phone'),
            'created_at' => Yii::t('app', 'Create time'),
            'updated_at' => Yii::t('app', 'Update time'),
            'published' => Yii::t('app', 'Published'),
            'deleted' => Yii::t('app', 'Deleted'),
            'full_name' => Yii::t('shop', 'Full name'),
            'user_id' => Yii::t('shop', 'User'),

        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::class, ['customer_id' => 'id']);
    }
}
