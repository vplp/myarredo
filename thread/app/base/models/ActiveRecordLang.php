<?php

namespace thread\app\base\models;

use Yii;
use yii\db\ActiveRecord as dbActiveRecord;

/**
 * Class ActiveRecordLang
 * Base ActiveRecord for language part [[ActiveRecordLang]]
 *
 * @package thread\app\base\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
abstract class ActiveRecordLang extends dbActiveRecord
{

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['rid', 'lang'], 'required'],
            ['rid', 'integer'],
            ['lang', 'string', 'min' => 5, 'max' => 5],
            [['rid', 'lang'], 'unique', 'targetAttribute' => ['rid', 'lang'], 'message' => 'The combination of rid and lang has already been taken.']
        ];
    }

    /**
     * @return $this
     */
    public static function find()
    {
        return parent::find()->onCondition([static::tableName() . '.lang' => Yii::$app->language]);
    }

    /**
     *
     * @return array
     */
    public function scenarios()
    {
        return [
            'backend' => ['title'],
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
}
