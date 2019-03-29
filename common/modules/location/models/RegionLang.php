<?php

namespace common\modules\location\models;

use Yii;
//
use thread\app\base\models\ActiveRecordLang;
use thread\modules\location\Location as LocationModule;

/**
 * Class CountryLang
 *
 * @property integer $rid
 * @property string $lang
 * @property string $title
 *
 * @package common\modules\location\models
 */
class RegionLang extends ActiveRecordLang
{
    /**
     * @return object|\yii\db\Connection|null
     * @throws \yii\base\InvalidConfigException
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
        return '{{%location_region_lang}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['rid'], 'required'],
            ['rid', 'integer'],
            ['rid', 'exist', 'targetClass' => Region::class, 'targetAttribute' => 'id'],
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
            'title' => Yii::t('app', 'Title'),
        ];
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return [
            'backend' => ['title'],
            'title' => ['title'],
        ];
    }
}
