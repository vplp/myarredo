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
 * @property string $type
 * @property string $content
 * @property integer $reminder_time
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $published
 * @property integer $deleted
 * @property integer $processed
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
            [['order_id', 'user_id', 'content'], 'required'],
            [['order_id', 'user_id', 'created_at', 'updated_at'], 'integer'],
            [['content'], 'string'],
            [
                ['reminder_time'],
                'date',
                'format' => 'php:j.m.Y',
                'timestampAttribute' => 'reminder_time'
            ],
            [['reminder_time'], 'default', 'value' => 0],
            [['published', 'deleted', 'processed'], 'in', 'range' => array_keys(self::statusKeyRange())],
            [['type'], 'in', 'range' => array_keys(self::typeKeyRange())],
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
            'processed' => ['processed'],
            'backend' => [
                'order_id',
                'user_id',
                'type',
                'content',
                'reminder_time',
                'published',
                'deleted',
                'processed'
            ],
            'frontend' => [
                'order_id',
                'user_id',
                'type',
                'content',
                'reminder_time',
                'published',
                'deleted',
                'processed'
            ],
        ];
    }

    /**
     * @return array
     */
    public static function typeKeyRange()
    {
        return [
            'comment' => Yii::t('shop', 'Комментарий'),
            'reminder' => Yii::t('shop', 'Напоминание')
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
            'content' => Yii::t('shop', 'Комментарий'),
            'reminder_time' => Yii::t('shop', 'Дата'),
            'created_at' => Yii::t('app', 'Create time'),
            'updated_at' => Yii::t('app', 'Update time'),
            'published' => Yii::t('app', 'Published'),
            'deleted' => Yii::t('app', 'Deleted'),
            'processed'
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
