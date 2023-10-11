<?php

namespace common\modules\forms\models;

use Yii;
use thread\app\base\models\ActiveRecord;
use common\modules\forms\FormsModule;
use common\modules\user\models\User;
use common\modules\shop\models\Order;
use common\modules\shop\models\Customer;

/**
 * Class Forms
 *
 * @property integer $id
 * @property integer $order_id
 * @property integer $user_id
 * @property string $question_1
 * @property string $question_2
 * @property string $question_3
 * @property string $question_4
 * @property integer $vote
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $published
 * @property integer $deleted
 *
 * @property User $user
 * @property Order $order
 *
 * @package common\modules\forms\models
 */
class FormsFeedbackAfterOrder extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%forms_feedback_after_order}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['question_1', 'question_2'], 'string', 'max' => 255],
            [['question_3, question_4'], 'string', 'max' => 2048],
            [['question_3'], 'required'],
            [['user_id, order_id','vote'], 'integer'],
            [['published', 'deleted'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [['created_at', 'updated_at', 'published', 'deleted'], 'integer'],
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
            'backend' => ['question_1', 'question_2', 'question_3', 'question_4', 'vote', 'user_id', 'order_id', 'published'],
            'frontend' => ['question_1', 'question_2', 'question_3', 'question_4', 'vote', 'user_id', 'order_id'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'question_1' => Yii::t('app', 'Осуществилась ли ваша покупка после запроса цены через наш сайт?'),
            'question_2' => Yii::t('app', 'На каком салоне вы остановили свой выбор?'),
            'question_3' => Yii::t('app', 'Какие впечатления у вас остались от взаимодействия с выбранным салоном?'),
            'question_4' => Yii::t('app', 'Чем все закончилось?'),
            'vote' => Yii::t('app', 'Оценка'),
            'order_id' => Yii::t('app', 'Order id'),
            'user_id' => Yii::t('app', 'Name'),
            'created_at' => Yii::t('app', 'Create time'),
            'updated_at' => Yii::t('app', 'Update time'),
            'published' => Yii::t('app', 'Published'),
            'deleted' => Yii::t('app', 'Deleted'),
        ];
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
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customer::class, ['id' => 'user_id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPartner()
    {
        return $this->hasOne(User::class, ['id' => 'question_2']);
    }


    /**
     * @return string
     */
    public function getPublishedTime()
    {
        $format = FormsModule::getFormatDate();
        return $this->created_at == 0 ? date($format) : date($format, $this->created_at);
    }

    /**
     * @return mixed
     */
    public static function findBase()
    {
        return self::find()->orderBy(self::tableName() . '.id DESC');
    }
}