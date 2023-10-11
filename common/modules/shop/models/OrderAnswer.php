<?php

namespace common\modules\shop\models;

use Yii;
//
use thread\app\base\models\ActiveRecord;
use common\modules\shop\Shop;
use common\modules\user\models\User;

/**
 * Class OrderAnswer
 *
 * @property integer $id
 * @property integer $order_id
 * @property integer $user_id
 * @property string $answer
 * @property string $answer_time
 * @property string $file
 * @property string $results
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
            [['order_id', 'user_id', 'answer'], 'required'],
            [['order_id', 'user_id', 'answer_time', 'created_at', 'updated_at'], 'integer'],
            [['answer', 'file'], 'string'],
            [['results'], 'string', 'max' => 255],
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
                'answer_time',
                'file',
                'results',
                'published',
                'deleted'
            ],
            'frontend' => [
                'order_id',
                'user_id',
                'answer',
                'answer_time',
                'file',
                'results',
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
            'answer' => Yii::t('app', 'Answer'),
            'answer_time' => Yii::t('app', 'Answer time'),
            'file' => Yii::t('app', 'File_answer'),
            'results' => Yii::t('app', 'Results'),
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
            ->andWhere([
                self::tableName() . '.order_id' => $order_id,
                self::tableName() . '.user_id' => $user_id
            ])
            ->one();
    }

    /**
     * @return string
     */
    public function getAnswerTime()
    {
        $format = 'd.m.Y H:i';
        return $this->answer_time == 0 ? '' : date($format, $this->answer_time);
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFile()
    {
        return !empty($this->file) ? \Yii::getAlias('@uploads').'/files/'.$this->file : '';
    }
}
