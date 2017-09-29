<?php

namespace common\modules\shop\models;

use Yii;
//
use thread\app\base\models\ActiveRecord;
use common\modules\shop\Shop;

/**
 * Class OrderAnswer
 *
 * @property integer $id
 * @property integer $order_id
 * @property integer $user_id
 * @property string $answer
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $published
 * @property integer $deleted
 *
 * @package common\modules\shop\models
 */
class OrderAnswer extends ActiveRecord
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
        return '{{%shop_order_answer}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['order_id', 'user_id'], 'required'],
            [['order_id', 'user_id', 'created_at', 'updated_at'], 'integer'],
            [['answer'], 'string'],
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
                'answer',
                'published',
                'deleted'
            ],
            'frontend' => [
                'order_id',
                'user_id',
                'answer',
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
            'user_id' => Yii::t('app', 'User id'),
            'answer' => Yii::t('app', 'Answer'),
            'created_at' => Yii::t('app', 'Create time'),
            'updated_at' => Yii::t('app', 'Update time'),
            'published' => Yii::t('app', 'Published'),
            'deleted' => Yii::t('app', 'Deleted'),
        ];
    }

    /**
     * @param $order_id
     * @param $user_id
     * @return mixed
     */
    public static function findByOrderIdUserId($order_id, $user_id)
    {
        return self::findBase()
            ->andWhere([self::tableName().'.order_id' => $order_id, self::tableName().'.user_id' => $user_id])
            ->one();
    }
}