<?php

namespace thread\modules\location\models;

use Yii;
//
use thread\modules\location\Location as LocationModule;

/**
 * Class CountryLang
 *
 * @package thread\modules\location\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class CountryLang extends \thread\app\base\models\ActiveRecordLang
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
        return '{{%location_country_lang}}';
    }

    /**
     *
     * @return array
     */
    public function rules()
    {
        return [
            [['rid', 'lang', 'title'], 'required'],
            ['rid', 'integer'],
            ['rid', 'exist', 'targetClass' => Country::class, 'targetAttribute' => 'id'],
            ['lang', 'string', 'min' => 5, 'max' => 5],
            ['title', 'string', 'max' => 128],
            [
                ['rid', 'lang'],
                'unique',
                'targetAttribute' => ['rid', 'lang'],
                'message' => 'The combination of rid and lang has already been taken.'
            ]
        ];
    }

    /**
     *
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

}
