<?php

namespace common\modules\user\models;

use Yii;
use yii\helpers\ArrayHelper;
//
use common\modules\user\User as UserModule;
//
use thread\app\base\models\ActiveRecordLang;

/**
 * Class ProfileLang
 *
 * @property integer $rid
 * @property string $lang
 * @property string $address
 * @property string $address2
 * @property string $name_company
 * @property string $about_company
 *
 * @package common\modules\user\models
 */
class ProfileLang extends ActiveRecordLang
{
    /**
     * @return object|string|\yii\db\Connection|null
     * @throws \yii\base\InvalidConfigException
     */
    public static function getDb()
    {
        return UserModule::getDb();
    }

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%user_profile_lang}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            ['rid', 'exist', 'targetClass' => Profile::class, 'targetAttribute' => 'id'],
            [['address', 'address2', 'name_company'], 'string', 'max' => 255],
            [['about_company'], 'string'],
            [['address', 'address2', 'name_company', 'about_company'], 'default', 'value' => ''],
        ]);
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return [
            'backend' => ['address','address2', 'name_company', 'about_company'],
            'basicCreate' => ['address','address2', 'name_company', 'about_company'],
            'ownEdit' => ['address','address2', 'name_company', 'about_company'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'address' => Yii::t('app', 'Address'),
            'address2' => Yii::t('app', 'Адрес 2-го салона'),
            'name_company' => Yii::t('app', 'Название компании'),
            'about_company' => 'Описание о компании',
        ];
    }
}
