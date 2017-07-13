<?php

namespace thread\modules\sys\modules\mail\models;

use Yii;
//
use thread\app\base\models\ActiveRecord;
use thread\modules\sys\modules\mail\Mail as MailModule;

/**
 * Class Message
 *
 * @package thread\modules\sys\modules\mail\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Message extends ActiveRecord
{

    /**
     * @return string
     */
    public static function getDb()
    {
        return MailModule::getDb();
    }

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%system_mail_message}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['user_id', 'message', 'type', 'priority', 'model'], 'required'],
            [['created_at', 'updated_at', 'user_id'], 'integer'],
            [['published', 'deleted', 'is_read'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [['priority'], 'in', 'range' => static::getPriorityRange()],
            [['type'], 'in', 'range' => array_keys(static::getTypeRange())],
            ['message', 'string', 'max' => 255],
            ['url', 'string', 'max' => 512],
            ['model', 'string', 'max' => 50],
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
            'backend' => ['type', 'priority', 'message', 'is_read', 'published', 'deleted', 'model', 'user_id', 'url'],
            'send' => ['type', 'priority', 'message', 'is_read', 'published', 'deleted', 'model', 'user_id', 'url'],
        ];
    }


    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'message' => 'message',
            'url' => 'url',
            'type' => 'type',
            'priority' => 'priority',
            'is_read' => 'is_read',
            'user_id' => 'user_id',
            'model' => 'model',
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
     * @return array
     */
    public static function getPriorityRange()
    {
        return [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
    }
}
