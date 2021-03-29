<?php

namespace common\modules\catalog\models;

use Yii;
use thread\app\base\models\ActiveRecord;
use common\modules\catalog\Catalog;

/**
 * Class FactorySubdivision
 *
 * @property integer $id
 * @property integer $region
 * @property integer $factory_id
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
    public $subdivision_in_cis;
    public $subdivision_in_italy;
    public $subdivision_in_europe;

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
            [['company_name', 'contact_person', 'email', 'phone'], 'required'],
            //[['factory_id'], 'required'],
            [['region'], 'in', 'range' => array_keys(static::regionKeyRange())],
            [['factory_id', 'created_at', 'updated_at'], 'integer'],
            [['published', 'deleted'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [['company_name', 'contact_person', 'email', 'phone'], 'string', 'max' => 255],
            [
                ['subdivision_in_cis', 'subdivision_in_italy', 'subdivision_in_europe'],
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
                'factory_id',
                'company_name',
                'contact_person',
                'email',
                'phone',
                'published',
                'deleted'
            ],
            'frontend' => [
                'region',
                'factory_id',
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
            'factory_id' => Yii::t('app', 'Factory'),
            'company_name',
            'contact_person',
            'email',
            'phone',
            'created_at' => Yii::t('app', 'Create time'),
            'updated_at' => Yii::t('app', 'Update time'),
            'published' => Yii::t('app', 'Published'),
            'deleted' => Yii::t('app', 'Deleted'),
            'subdivision_in_cis' => 'Представительство в Странах СНГ',
            'subdivision_in_italy' => 'Представительство в Италии',
            'subdivision_in_europe' => 'Представительство в Европе',
        ];
    }

    /**
     * @return array
     */
    public static function regionKeyRange()
    {
        return [
            0 => 'СНГ',
            1 => 'Италия',
            2 => 'Европа',
        ];
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
    public function getFactory()
    {
        return $this->hasOne(Factory::class, ['id' => 'factory_id']);
    }
}
