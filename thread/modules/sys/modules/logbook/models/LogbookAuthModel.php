<?php

namespace thread\modules\sys\modules\logbook\models;

use thread\app\base\models\ActiveRecord;
use thread\modules\sys\modules\logbook\Logbook as ParentModule;
use thread\modules\user\models\User;
use Yii;

/**
 * Class LogbookAuthModel
 *
 * @package thread\modules\sys\modules\logbook\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class LogbookAuthModel extends ActiveRecord
{
    const TYPE_NOTICE = 'notice';
    const TYPE_WARNING = 'warning';
    const TYPE_ERROR = 'error';
    const ACTIONS_LIST = [
        'login',
        'logout'
    ];


    /**
     * @return string
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
        return '{{%system_logbook_auth}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['user_id', 'message', 'type', 'category'], 'required'],
            [['created_at', 'updated_at', 'user_id'], 'integer'],
            [['published', 'deleted', 'is_read'], 'in', 'range' => \array_keys(static::statusKeyRange())],
            [['type'], 'in', 'range' => \array_keys(static::getTypeRange())],
            ['action', 'string', 'max' => 50],
            ['user_ip', 'string', 'max' => 25],
            ['user_agent', 'string', 'max' => 255],
            [['type'], 'default', 'value' => self::TYPE_NOTICE],
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
            'is_read' => ['is_read'],
            'backend' => ['type', 'is_read', 'published', 'deleted', 'action', 'user_id', 'user_ip', 'user_agent'],
            'send' => ['created_at', 'type', 'is_read', 'published', 'deleted', 'action', 'user_id', 'user_ip', 'user_agent'],
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
            'is_read' => 'is_read',
            'user_id' => Yii::t('app', 'User'),
            'action' => Yii::t('app', 'Actions'),
            'created_at' => Yii::t('app', 'Create time'),
            'updated_at' => Yii::t('app', 'Updated at'),
            'published' => Yii::t('app', 'Published'),
            'deleted' => Yii::t('app', 'Deleted'),
            'user_ip' => 'IP',
            'user_agent' => 'Agent',
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
