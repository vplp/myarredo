<?php

namespace common\modules\catalog\models;

use Yii;
//
use thread\app\base\models\ActiveRecord;
//
use common\modules\catalog\Catalog;
use common\modules\location\models\{
    City, Country
};

/**
 * Class SaleStatsDays
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $factory_id
 * @property integer $country_id
 * @property integer $city_id
 * @property integer $views
 * @property integer $requests
 * @property integer $date
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @package common\modules\catalog\models
 */
class SaleStatsDays extends ActiveRecord
{
    public $count;

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
        return '{{%catalog_sale_item_stats_days}}';
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
            [
                [
                    'product_id',
                    'factory_id',
                    'country_id',
                    'city_id',
                    'views',
                    'requests',
                    'date',
                    'create_time',
                    'update_time'
                ],
                'integer'
            ],
            [['views', 'requests'], 'default', 'value' => 0]
        ];
    }

    public function validateProductCityDate()
    {
        $data = self::find()
            ->andWhere(['product_id' => $this->product_id])
            ->andWhere(['city_id' => $this->city_id])
            ->andWhere(['date' => $this->date])
            ->one();

        if ($data != null) {
            $this->addError('product_id', Yii::t('yii', '{attribute} "{value}" has already been taken.'));
            $this->addError('city_id', Yii::t('yii', '{attribute} "{value}" has already been taken.'));
            $this->addError('date', Yii::t('yii', '{attribute} "{value}" has already been taken.'));
        }
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return [
            'frontend' => [
                'product_id',
                'factory_id',
                'country_id',
                'city_id',
                'views',
                'requests',
                'date',
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
            'product_id',
            'factory_id',
            'country_id',
            'city_id',
            'views',
            'requests',
            'date',
            'created_at' => Yii::t('app', 'Create time'),
            'updated_at' => Yii::t('app', 'Update time'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSale()
    {
        return $this->hasOne(Sale::class, ['id' => 'product_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFactory()
    {
        return $this->hasOne(Factory::class, ['id' => 'factory_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::class, ['id' => 'city_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->city->country;
    }

    /**
     * @return string
     */
    public function getDateTime()
    {
        $format = 'd.m.Y';
        return $this->date == 0 ? date($format) : date($format, $this->date);
    }

    /**
     * @return mixed
     */
    public static function findBase()
    {
        return self::find()
            ->innerJoinWith(['sale', 'factory'])
            ->orderBy('requests DESC');
    }

    /**
     * @return array
     */
    public static function getTypeLabel()
    {
        return [
            'views' => Yii::t('app', 'Просмотры'),
            'requests' => Yii::t('app', 'Заявки')
        ];
    }
}
