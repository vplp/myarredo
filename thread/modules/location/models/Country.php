<?php

namespace thread\modules\location\models;

use Yii;
use yii\behaviors\AttributeBehavior;
use yii\helpers\{
    ArrayHelper, Inflector
};
//
use thread\app\base\models\ActiveRecord;
use thread\modules\location\Location as LocationModule;

/**
 * Class Country
 *
 * @property integer $id
 * @property integer $bookId
 * @property string $alias
 * @property string $alpha2
 * @property string $alpha3
 * @property string $iso
 * @property integer $published
 * @property integer $deleted
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $position
 *
 * @package thread\modules\location\models
 */
class Country extends ActiveRecord
{
    /**
     * @return object|\yii\db\Connection|null
     * @throws \yii\base\InvalidConfigException
     */
    public static function getDb()
    {
        return LocationModule::getDb();
    }

    /**
     * Table name
     *
     * @return string
     */
    public static function tableName()
    {
        return '{{%location_country}}';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                [
                    'class' => AttributeBehavior::className(),
                    'attributes' => [
                        ActiveRecord::EVENT_BEFORE_INSERT => 'alias',
                        ActiveRecord::EVENT_BEFORE_UPDATE => 'alias',
                    ],
                    'value' => function ($event) {
                        return Inflector::slug($this->alias);
                    },
                ],
            ]
        );
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['alias'], 'required'],
            [
                [
                    'created_at',
                    'position',
                    'updated_at',
                    'iso',
                ],
                'integer'
            ],
            [['published', 'deleted'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [['position'], 'default', 'value' => 0],
            [['alias'], 'string', 'max' => 128],
            [['alpha2'], 'string', 'min' => 2, 'max' => 2],
            [['alpha3'], 'string', 'min' => 3, 'max' => 3],
            [['alias'], 'unique'],
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
                'alias',
                'alpha2',
                'alpha3',
                'iso',
                'published',
                'deleted',
                'position',
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
            'alias' => Yii::t('app', 'Alias'),
            'alpha2' => Yii::t('location', 'alpha2'),
            'alpha3' => Yii::t('location', 'alpha3'),
            'iso' => Yii::t('location', 'iso'),
            'created_at' => Yii::t('app', 'Create time'),
            'updated_at' => Yii::t('app', 'Update time'),
            'published' => Yii::t('app', 'Published'),
            'deleted' => Yii::t('app', 'Deleted'),
            'position' => Yii::t('app', 'Position'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(CountryLang::class, ['rid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getCurrencies()
    {
        return $this->hasMany(Currency::class, ['id' => 'currency_id'])
            ->viaTable('%location_rel_country_currency', ['country_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCities()
    {
        return $this->hasMany(City::class, ['country_id' => 'id']);
    }

    /**
     * @return int|string
     */
    public function getCitiesCount()
    {
        return $this->getCities()->count();
    }

    /**
     * @param string $countryCode
     *
     * @return bool
     */
    public function checkCountryExists(string $countryCode): bool
    {
        return !empty(self::findOne(['alias' => $countryCode]));
    }
}
