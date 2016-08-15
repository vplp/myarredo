<?php

namespace thread\modules\location\models;

use Yii;
//
use thread\app\base\models\ActiveRecordLang;
use thread\modules\location\Location as LocationModule;

/**
 * Class CompanyLang
 *
 * @package thread\modules\location\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class CompanyLang extends ActiveRecordLang
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
        return '{{%location_company_lang}}';
    }

    /**
     * Rules
     *
     * @return array
     */
    public function rules()
    {
        return [
            [['rid'], 'required'],
            ['rid', 'integer'],
            ['rid', 'exist', 'targetClass' => Company::class, 'targetAttribute' => 'id'],
            ['lang', 'string', 'min' => 5, 'max' => 5],
            [['title', 'street', 'house'], 'string', 'max' => 255]
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
            'street' => Yii::t('app', 'street'),
            'house' => Yii::t('app', 'house')
        ];
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return [
            'backend' => ['title', 'street', 'house'],
        ];
    }

}
