<?php

namespace common\modules\shop\models;

use Yii;
use thread\app\base\models\ActiveRecord;
use common\modules\shop\Shop;
use common\modules\user\models\User;

/**
 * Class OrderComment
 *
 * @property integer $id
 * @property integer $order_id
 * @property integer $user_id
 * @property string $comment
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $published
 * @property integer $deleted
 *
 * @property User $user
 * @property Order $order
 *
 * @package common\modules\shop\models
 */
class OrderComment extends ActiveRecord
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
        return '{{%shop_order_comment}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['order_id', 'user_id', 'comment'], 'required'],
            [['order_id', 'user_id', 'created_at', 'updated_at'], 'integer'],
            [['comment'], 'string'],
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
                'order_id',
                'user_id',
                'comment',
                'published',
                'deleted'
            ],
            'frontend' => [
                'order_id',
                'user_id',
                'comment',
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
            'order_id' => Yii::t('app', 'Order id'),
            'user_id' => Yii::t('app', 'User'),
            'comment' => Yii::t('shop', 'Комментарий'),
            'created_at' => Yii::t('app', 'Create time'),
            'updated_at' => Yii::t('app', 'Update time'),
            'published' => Yii::t('app', 'Published'),
            'deleted' => Yii::t('app', 'Deleted'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::class, ['id' => 'order_id']);
    }
}
