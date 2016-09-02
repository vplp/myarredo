<?php

namespace thread\modules\sys\modules\user\models;

use Yii;
//
use thread\app\base\models\ActiveRecord;
use thread\modules\sys\modules\user\User as UserModule;

/**
 * Class AuthRole
 *
 * @package thread\modules\sys\user\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class AuthRole extends ActiveRecord
{

    /**
     * @return string
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
        return '{{%auth_item}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['name', 'unique'],
            ['name', 'required'],
            [['created_at', 'updated_at', 'type'], 'integer'],
            [['description', 'data'], 'string', 'max' => 1024],
            [['rule_name', 'name'], 'string', 'max' => 64],
            [['type'], 'default', 'value' => 1],
        ];
    }


    /**
     * @return array
     */
    public function scenarios()
    {
        return [
            'backend' => ['name', 'description', 'data', 'rule_name', 'type'],
        ];
    }


    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app', 'Name'),
            'description' => 'description',
            'data' => 'data',
            'rule_name' => 'rule_name',
            'type' => 'type',
            'created_at' => Yii::t('app', 'Created at'),
            'updated_at' => Yii::t('app', 'Updated at'),
        ];
    }
}
