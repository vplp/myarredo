<?php

namespace thread\modules\location\models;

use Yii;
//
use thread\app\base\models\ActiveRecordLang;
use thread\modules\location\Location as LocationModule;

/**
 * Class CurrencyLang
 *
 * @package thread\location\user\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class CurrencyLang extends ActiveRecordLang
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
        return '{{%location_currency_lang}}';
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
            ['rid', 'exist', 'targetClass' => Currency::class, 'targetAttribute' => 'id'],
            ['lang', 'string', 'min' => 5, 'max' => 5],
            ['title', 'string', 'max' => 255],
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
