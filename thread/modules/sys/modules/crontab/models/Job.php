<?php

namespace thread\modules\sys\modules\crontab\models;

use Yii;
//
use thread\app\base\models\ActiveRecord;
use thread\modules\sys\modules\crontab\Crontab as CrontabModule;

/**
 * Class Job
 *
 * @package thread\modules\sys\modules\crontab\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Job extends ActiveRecord
{

    /**
     * @return string
     */
    public static function getDb()
    {
        return CrontabModule::getDb();
    }

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%system_crontab_job}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['command'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['published', 'deleted'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [['minute'], 'in', 'range' => static::minuteRange()],
            [['hour'], 'in', 'range' => static::hourRange()],
            [['day'], 'in', 'range' => static::dayRange()],
            [['month'], 'in', 'range' => static::monthRange()],
            [['weekDay'], 'in', 'range' => static::weekDayRange()],
            [['command'], 'string', 'max' => 2048],
            [['minute', 'hour', 'day', 'month', 'weekDay'], 'default', 'value' => '*']
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
            'backend' => ['command', 'minute', 'hour', 'day', 'month', 'weekDay', 'published', 'deleted'],
        ];
    }


    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'command' => Yii::t('crontab', 'Command'),
            'minute' => Yii::t('crontab', 'Minute'),
            'hour' => Yii::t('crontab', 'Hour'),
            'day' => Yii::t('crontab', 'Day'),
            'month' => Yii::t('crontab', 'Month'),
            'weekDay' => Yii::t('crontab', 'WeekDay'),
            'created_at' => Yii::t('app', 'Created at'),
            'updated_at' => Yii::t('app', 'Updated at'),
            'published' => Yii::t('app', 'Published'),
            'deleted' => Yii::t('app', 'Deleted'),
        ];
    }

    /**
     * @return array
     */
    public static function minuteRange()
    {
        return ['*', 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59];
    }

    /**
     * @return array
     */
    public static function hourRange()
    {
        return ['*', 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23];
    }

    /**
     * @return array
     */
    public static function dayRange()
    {
        return ['*', 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 20, 30];
    }

    /**
     * @return array
     */
    public static function monthRange()
    {
        return ['*', 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11];
    }

    /**
     * @return array
     */
    public static function weekDayRange()
    {
        return ['*', 0, 1, 2, 3, 4, 5, 6];
    }

    /**
     * @return mixed
     */
    public static function findJobToWork()
    {
        return self::find()->enabled()->all();
    }

    /**
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        CrontabModule::setJobs();
    }
}
