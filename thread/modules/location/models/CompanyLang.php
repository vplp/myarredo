<?php

namespace thread\modules\location\models;

use thread\app\base\models\ActiveRecordLang;
use Yii;

/**
 * Class CompanyLang
 * @package thread\modules\location\models
 */
class CompanyLang extends ActiveRecordLang
{

    /**
     *
     * @return string
     */
    public static function getDb()
    {
        return \thread\modules\location\Location::getDb();
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
