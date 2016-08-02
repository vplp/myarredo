<?php

namespace thread\modules\location\models;

use Yii;
//
use thread\app\base\models\ActiveRecordLang;
use thread\modules\location\Location as LocationModule;

/**
 * Class CountryLang
 *
 * @package thread\modules\location\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class CityLang extends ActiveRecordLang
{

    /**
     *
     * @return string
     */
    public static function getDb()
    {
        return LocationModule::getDb();
    }

    /**
     *
     * @return string
     */
    public static function tableName()
    {
        return '{{%location_city_lang}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['rid'], 'required'],
            ['rid', 'integer'],
            ['rid', 'exist', 'targetClass' => City::class, 'targetAttribute' => 'id'],
            ['lang', 'string', 'min' => 5, 'max' => 5],
            ['title', 'string', 'max' => 128]
        ];
    }


    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'rid' => Yii::t('app', 'rid'),
            'lang' => Yii::t('app', 'lang'),
            'title' => Yii::t('app', 'title'),
        ];
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return [
            'backend' => ['title'],
        ];
    }

}
