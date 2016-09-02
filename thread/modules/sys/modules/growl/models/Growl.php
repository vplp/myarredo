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
     * @return string
     */
    public static function tableName()
    {
        return '{{%growl}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['user_id', 'message', 'type', 'priority'], 'required'],
            [['created_at', 'updated_at', 'user_id'], 'integer'],
            [['published', 'deleted', 'is_read'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [['priority'], 'in', 'range' => static::getPriorityRange()],
            [['type'], 'in', 'range' => array_keys(static::getPriorityRange())],
            ['message', 'string', 'max' => 255],
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
            'backend' => ['type', 'priority', 'message', 'is_read', 'published', 'deleted'],
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
            'type' => 'type',
            'priority' => 'priority',
            'is_read' => 'is_read',
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
