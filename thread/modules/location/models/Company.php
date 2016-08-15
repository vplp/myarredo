<?php

namespace thread\modules\location\models;

use Yii;
//
use thread\app\base\models\ActiveRecord;
use thread\modules\location\Location as LocationModule;

/**
 * Class Company
 *
 * @package thread\modules\location\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Company extends ActiveRecord
{

    /**
     * @inheritdoc
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
        return '{{%location_company}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['published', 'deleted'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [['country_id', 'city_id', 'created_at', 'updated_at'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'id'),
            'country_id' => Yii::t('app', 'Country'),
            'city_id' => Yii::t('app', 'city_id'),
            'updated_at' => Yii::t('app', 'updated_at'),
            'published' => Yii::t('app', 'published'),
            'deleted' => Yii::t('app', 'deleted'),
        ];
    }

    /**
     *
     * @return array
     */
    public function scenarios()
    {
        return [
            'published' => ['published'],
            'deleted' => ['deleted'],
            'backend' => [
                'city_id',
                'country_id',
                'created_at',
                'updated_at',
                'published',
                'deleted'
            ],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(CompanyLang::class, ['rid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */

    public function getCountry()
    {
        return $this->hasOne(Country::class, ['id' => 'country_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::class, ['id' => 'city_id']);
    }

}
