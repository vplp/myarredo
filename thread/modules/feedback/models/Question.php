<?php

namespace thread\modules\feedback\models;

use Yii;
//
use thread\app\base\models\ActiveRecord;
use thread\modules\feedback\Feedback as ParentModule;

/**
 * Class Question
 *
 * @package thread\modules\feedback\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Question extends ActiveRecord
{
    /**
     * @return null|object|string
     */
    public static function getDb()
    {
        return ParentModule::getDb();
    }

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%feedback_question}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['user_name', 'question', 'email', 'subject'], 'required'],
            [['create_time', 'update_time', 'group_id'], 'integer'],
            [['user_name', 'question', 'subject'], 'string', 'max' => 255],
            [['email'], 'email'],
            [['published', 'deleted'], 'in', 'range' => array_keys(static::statusKeyRange())],
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
            'backend' => ['subject', 'group_id', 'published', 'deleted', 'user_name', 'question', 'email'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'group_id' => Yii::t('app', 'Group'),
            'user_name' => Yii::t('feedback', 'User'),
            'email' => Yii::t('feedback', 'Email'),
            'question' => Yii::t('feedback', 'Message'),
            'created_at' => Yii::t('app', 'Create time'),
            'updated_at' => Yii::t('app', 'Update time'),
            'published' => Yii::t('app', 'Published'),
            'deleted' => Yii::t('app', 'Deleted'),
            'subject' => Yii::t('app', 'Subject'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(Group::class, ['id' => 'group_id']);
    }
}
