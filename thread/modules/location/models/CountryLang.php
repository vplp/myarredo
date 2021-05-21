<?php

namespace thread\modules\location\models;

use Yii;
use thread\modules\location\Location as LocationModule;

/**
 * Class CountryLang
 *
 * @property string $title
 *
 * @package thread\modules\location\models
 */
class CountryLang extends \thread\app\base\models\ActiveRecordLang
{
    /**
     * @return null|object
     */
    public static function getDb()
    {
        return LocationModule::getDb();
    }

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%location_country_lang}}';
    }

    /**
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
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'title' => Yii::t('app', 'Title'),
        ];
    }
}
