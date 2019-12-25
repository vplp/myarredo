<?php

namespace thread\modules\sys\modules\logbook\models;

use thread\app\base\models\ActiveRecord;
use thread\modules\sys\modules\logbook\Logbook as ParentModule;
use thread\modules\user\models\User;
use Yii;

/**
 * Class Logbook
 *
 * @package thread\modules\sys\modules\logbook\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 *
 * @property $updated_at int
 */
class Logbook extends ActiveRecord
{
    const TYPE_NOTICE = 'notice';
    const TYPE_WARNING = 'warning';
    const TYPE_ERROR = 'error';

    /**
     * @return object|string|\yii\db\Connection|null
     * @throws \yii\base\InvalidConfigException
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
            [['published', 'deleted', 'is_read'], 'in', 'range' => \array_keys(static::statusKeyRange())],
            [['type'], 'in', 'range' => \array_keys(static::getTypeRange())],
            [['message', 'url'], 'string', 'max' => 512],
            ['category', 'string', 'max' => 50],
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
            'backend' => ['type', 'url', 'message', 'is_read', 'published', 'deleted', 'category', 'user_id'],
            'send' => ['created_at', 'type', 'url', 'message', 'is_read', 'published', 'deleted', 'category', 'user_id'],
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
            'category' => Yii::t('app', 'Category'),
            'created_at' => Yii::t('app', 'Create time'),
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

    /**
     *  ISO8601 = "Y-m-d\TH:i:sO"
     * @return string
     */
    public function getModifiedTimeISO()
    {
        return \date('Y-m-d\TH:i:sO', $this->updated_at);
    }
}
