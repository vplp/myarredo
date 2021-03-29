<?php

namespace common\modules\catalog\models;

use Yii;
use thread\app\base\models\ActiveRecord;
use common\modules\catalog\Catalog;
use common\modules\user\models\User;

/**
 * Class FactorySubdivision
 *
 * @property integer $id
 * @property integer $region
 * @property integer $user_id
 * @property string $company_name
 * @property string $contact_person
 * @property integer $email
 * @property integer $phone
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $published
 * @property integer $deleted
 *
 * @package common\modules\catalog\models
 */
class FactorySubdivision extends ActiveRecord
{
    public $subdivision;

    /**
     * @return object|string|\yii\db\Connection|null
     * @throws \yii\base\InvalidConfigException
     */
    public static function getDb()
    {
        return Catalog::getDb();
    }

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%catalog_factory_subdivision}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['region'], 'in', 'range' => array_keys(static::regionKeyRange())],
            [['user_id', 'created_at', 'updated_at'], 'integer'],
            [['published', 'deleted'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [['company_name', 'contact_person', 'email', 'phone'], 'string', 'max' => 255],
            [['email'], 'email'],
            [
                ['subdivision'],
                'in',
                'range' => [0, 1]
            ],
        ];
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return [
            'published' => ['published'],
            'deleted' => ['deleted'],
            'backend' => [
                'region',
                'user_id',
                'company_name',
                'contact_person',
                'email',
                'phone',
                'published',
                'deleted'
            ],
            'frontend' => [
                'region',
                'user_id',
                'company_name',
                'contact_person',
                'email',
                'phone',
                'published',
                'deleted'
            ],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'region',
            'user_id',
            'company_name' => Yii::t('app', 'Название компании'),
            'contact_person' => Yii::t('app', 'Контактное лицо'),
            'email' => Yii::t('app', 'Email'),
            'phone' => Yii::t('app', 'Phone'),
            'created_at' => Yii::t('app', 'Create time'),
            'updated_at' => Yii::t('app', 'Update time'),
            'published' => Yii::t('app', 'Published'),
            'deleted' => Yii::t('app', 'Deleted'),
        ];
    }

    /**
     * @return array
     */
    public static function regionKeyRange($key)
    {
        $data = [
            0 => Yii::t('app', 'Представительство в Странах СНГ'),
            1 => Yii::t('app', 'Представительство в Италии'),
            2 => Yii::t('app', 'Представительство в Европе'),
        ];

        if ($key) {
            return $data[$key];
        } else {
            return $data;
        }
    }

    /**
     * @return mixed
     */
    public static function findBase()
    {
        return self::find();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
