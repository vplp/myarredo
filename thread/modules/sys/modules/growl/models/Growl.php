<?php

namespace thread\modules\sys\modules\growl\models;

use Yii;
//
use thread\app\base\models\ActiveRecord;
use thread\modules\sys\modules\growl\Growl as GrowlModule;

/**
 * Class Growl
 *
 * @package thread\modules\sys\modules\growl\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Growl extends ActiveRecord
{

    /**
     * @return string
     */
    public static function getDb()
    {
        return GrowlModule::getDb();
    }

    /**
     * @var
     */
    public static $commonQuery = query\ActiveQuery::class;

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%system_growl}}';
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
            'is_read' => ['is_read '],
            'backend' => ['type', 'message', 'is_read', 'published', 'deleted', 'model', 'user_id', 'url'],
            'send' => ['type', 'message', 'is_read', 'published', 'deleted', 'model', 'user_id', 'url'],
        ];
    }


    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'message' => Yii::t('growl', 'Message'),
            'url' => Yii::t('growl', 'Url'),
            'type' => Yii::t('app', 'Type'),
            'is_read' => Yii::t('app', 'Readonly'),
            'user_id' => Yii::t('growl', 'To user'),
            'model' => Yii::t('app', 'Model'),
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
//            'error' => Yii::t('app', 'error'),
            'danger' => Yii::t('app', 'danger'),
            'success' => Yii::t('app', 'success'),
            'primary' => Yii::t('app', 'primary'),
        ];
    }

    /**
     * @param array $ids
     * @param $message
     * @param string $type
     * @param string $url
     * @return mixed
     */
    public static function sendByUserIds(array $ids, $message, $type = 'notice', $url = '')
    {
        foreach ($ids as $id) {
            $data[] = [
                $id, $message, 'growl', $url, $type, self::STATUS_KEY_OFF, time(), time(), self::STATUS_KEY_ON, self::STATUS_KEY_OFF
            ];
        }

        return self::getDb()->createCommand()->batchInsert(self::tableName(),
            ['user_id', 'message', 'model', 'url', 'type', 'is_read', 'created_at', 'updated_at', 'published', 'deleted'],
            $data)->execute();
    }
}
