<?php

namespace thread\modules\sys\modules\logbook\models;

use Yii;
//
use thread\app\base\models\ActiveRecord;
use thread\modules\sys\modules\logbook\Logbook as LogbookModule;
use thread\modules\user\models\User;

/**
 * Class Logbook
 *
 * @package thread\modules\sys\modules\logbook\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Logbook extends ActiveRecord
{

    /**
     * @return string
     */
    public static function getDb()
    {
        return LogbookModule::getDb();
    }

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%system_logbook}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['user_id', 'message', 'type', 'category'], 'required'],
            [['created_at', 'updated_at', 'user_id'], 'integer'],
            [['published', 'deleted', 'is_read'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [['type'], 'in', 'range' => array_keys(static::getTypeRange())],
            [['message', 'category'], 'string', 'max' => 512],
        ];
    }


    /**
     * @return array
     */
    public function scenarios()
    {
        return [
            'published' => ['published'],
            'is_read' => ['is_read'],
            'deleted' => ['deleted'],
            'backend' => ['type', 'message', 'is_read', 'published', 'deleted', 'category', 'user_id'],
            'send' => ['type', 'message', 'is_read', 'published', 'deleted', 'category', 'user_id'],
        ];
    }


    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'message' => Yii::t('app', 'Message'),
            'type' => Yii::t('app', 'Type'),
            'is_read' => Yii::t('app', 'Is read'),
            'user_id' => Yii::t('app', 'User'),
            'category' => Yii::t('app', 'Category'),
            'created_at' => Yii::t('app', 'Created at'),
            'updated_at' => Yii::t('app', 'Updated at'),
            'published' => Yii::t('app', 'Published'),
            'deleted' => Yii::t('app', 'Deleted'),
        ];
    }

    /**
     * @return array
     */
    public static function getTypeRange()
    {
        return [
            'notice' => Yii::t('app', 'notice'),
            'warning' => Yii::t('app', 'warning'),
            'error' => Yii::t('app', 'error'),
        ];
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
