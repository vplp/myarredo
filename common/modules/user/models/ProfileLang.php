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
 * @property string $name_company
 *
 * @package common\modules\user\models
 */
class ProfileLang extends ActiveRecordLang
{
    /**
     * @return string|\yii\db\Connection
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
            [['address', 'name_company'], 'string', 'max' => 255],
        ]);
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return [
            'backend' => ['address', 'name_company'],
            'basicCreate' => ['address', 'name_company'],
            'ownEdit' => ['address', 'name_company'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'address' => Yii::t('app', 'Address'),
            'name_company' => Yii::t('app', 'Название компании'),
        ];
    }
}
