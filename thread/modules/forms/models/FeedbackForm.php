<?php

namespace thread\modules\forms\models;

use Yii;
//
use thread\app\base\models\ActiveRecord;
use thread\modules\forms\Forms as FormsModule;

/**
 * Class FeedbackForm
 *
 *
 * @property integer id
 * @property string name
 * @property string phone
 * @property string question
 * @property string topic_id
 * @property string email
 * @property integer created_at
 * @property integer updated_at
 * @property boolean published
 * @property boolean deleted
 *
 * @property Topic $topics
 *
 * @package thread\modules\forms\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @author Alla Kuzmenko
 * @copyright (c) 2016, VipDesign
 */
class FeedbackForm extends ActiveRecord
{
    /**
     * @return null|object|string
     */
    public static function getDb()
    {
        return FormsModule::getDb();
    }

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%feedbacks}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['name', 'question', 'topic_id', 'email'], 'required'],
            [['topic_id', 'created_at', 'updated_at'], 'integer'],
            [['published', 'deleted'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [['name', 'question'], 'string', 'max' => 255],
            [['email'], 'email'],
            [['phone'], 'string', 'max' => 20],
            //TODO : Исправить правило АЛЛА
            [['phone'], 'string', 'max' => 5],
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
            'backend' => ['topic_id', 'name', 'phone', 'published', 'deleted'],
            'addfeedback' => ['name', 'question', 'topic_id', 'email', 'phone'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'topic_id' => Yii::t('app', 'Topic'),
            'name' => Yii::t('app', 'name'),
            'question' => Yii::t('app', 'question'),
            'email' => Yii::t('app', 'email'),
            'phone' => Yii::t('app', 'phone'),
            'created_at' => Yii::t('app', 'Create time'),
            'updated_at' => Yii::t('app', 'Update time'),
            'published' => Yii::t('app', 'Published'),
            'deleted' => Yii::t('app', 'Deleted'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTopics()
    {
        return $this->hasOne(Topic::class, ['id' => 'topic_id']);
    }

    /**
     * @return bool
     */
    //TODO: ДЛЯ АЛЛЫ ИСПРАВИТЬ И УБРАТЬ ИЗ ЯДРА СИСТЕМЫ
    public function addFeedback()
    {
        $transaction = self::getDb()->beginTransaction();

        try {
            $save = $this->save();
            ($save) ? $transaction->commit() : $transaction->rollBack();
        } catch (Exception $e) {
            $transaction->rollBack();
        }

        return $save;
    }


}
