<?php

namespace common\modules\forms\models;

use common\modules\location\models\City;
use common\modules\location\models\Country;
use Yii;
use thread\app\base\models\ActiveRecord;
use common\modules\forms\FormsModule;

/**
 * Class ClickOnBecomePartner
 *
 * @property integer $id
 * @property integer $country_id
 * @property integer $city_id
 * @property string $ip
 * @property string $http_user_agent
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $mark
 *
 * @package common\modules\catalog\models
 */
class ClickOnBecomePartner extends ActiveRecord
{
    public $count;

    /**
     * @return object|string|\yii\db\Connection|null
     * @throws \yii\base\InvalidConfigException
     */
    public static function getDb()
    {
        return FormsModule::getDb();
    }

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%forms_click_on_become_partner}}';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return parent::behaviors();
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['ip'], 'string', 'max' => 45],
            [['http_user_agent'], 'string', 'max' => 512],
            [
                [
                    'country_id',
                    'city_id',
                    'create_time',
                    'update_time',
                ],
                'integer'
            ]
        ];
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return [
            'frontend' => [
                'country_id',
                'city_id',
                'ip',
                'http_user_agent',
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
            'country_id' => Yii::t('app', 'Country'),
            'city_id' => Yii::t('app', 'City'),
            'ip',
            'http_user_agent',
            'created_at' => Yii::t('app', 'Create time'),
            'updated_at' => Yii::t('app', 'Update time'),
        ];
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

    /**
     * @return mixed
     */
    public static function findBase()
    {
        return self::find()
            ->select([
                self::tableName() . '.country_id',
                self::tableName() . '.city_id',
                'count(' . self::tableName() . '.city_id) as count'
            ])
            ->groupBy([self::tableName() . '.country_id', self::tableName() . '.city_id'])
            ->orderBy('count DESC');
    }
}
