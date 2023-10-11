<?php

namespace thread\app\base\models;

use Yii;
use yii\caching\DbDependency;
use yii\helpers\ArrayHelper;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord as dbActiveRecord;
//
use backend\modules\sys\modules\logbook\behaviors\LogbookBehavior;

/**
 * class ActiveRecord
 * Base ActiveRecord [[ActiveRecord]]
 *
 * @package thread\app\base\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
abstract class ActiveRecord extends dbActiveRecord
{

    const STATUS_KEY_ON = '1';
    const STATUS_KEY_OFF = '0';

    /**
     * @var
     */
    public static $commonQuery = query\ActiveQuery::class;

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    dbActiveRecord::EVENT_BEFORE_INSERT => ['updated_at', 'created_at'],
                    dbActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
//            'LogbookBehavior' => [
//                'class' => LogbookBehavior::class,
//                'category' => self::className(),
//            ]
        ];
    }

    /**
     * @return mixed
     */
    public static function find()
    {
        return new static::$commonQuery(get_called_class());
    }

    /**
     * @return mixed
     */
    public static function findBase()
    {
        return self::find();
    }

    /**
     * @return array
     */
    public static function statusKeyRange()
    {
        return [
            static::STATUS_KEY_ON => Yii::t('app', 'KEY_ON'),
            static::STATUS_KEY_OFF => Yii::t('app', 'KEY_OFF')
        ];
    }

    /**
     * @param $attribute
     * @return bool
     */
    public function isAttribute($attribute)
    {
        return (in_array($attribute, $this->attributes())) ? true : false;
    }

    /**
     * @param $scenario
     * @return bool
     */
    public function isScenario($scenario)
    {
        return (array_key_exists($scenario, $this->scenarios())) ? true : false;
    }

    /**
     * @param $query
     * @return DbDependency
     */
    public static function generateDependency($query)
    {
        $dependencyQuery = clone $query;
        $modelClass = $query->modelClass;

        $dependencyQuery->select(['MAX(' . $modelClass::tableName() . '.updated_at)']);
        $dependencySql = $dependencyQuery->createCommand()->getRawSql();

        $dependency = new DbDependency(['sql' => $dependencySql]);
        $dependency->reusable = true;

        return $dependency;
    }
}
