<?php

namespace common\modules\catalog\models;

use common\modules\location\models\City;
use Yii;
use yii\helpers\{
    ArrayHelper
};
use voskobovich\behaviors\ManyToManyBehavior;
//
use thread\app\base\models\ActiveRecord;
//
use common\modules\catalog\Catalog;

/**
 * Class FactoryPromotion
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $country_id
 * @property integer $views
 * @property integer $count_of_months
 * @property double $daily_budget
 * @property double $cost
 * @property boolean $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property boolean $published
 * @property boolean $deleted
 * @property array $city_ids
 * @property array $product_ids
 *
 * @property FactoryPromotionRelCity[] $cities
 * @property FactoryPromotionRelProduct[] $products
 *
 * @package common\modules\catalog\models
 */
class FactoryPromotion extends ActiveRecord
{
    /**
     * @return string
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
        return '{{%catalog_factory_promotion}}';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            [
                'class' => ManyToManyBehavior::className(),
                'relations' => [
                    'city_ids' => 'cities',
                ],
            ],
            [
                'class' => ManyToManyBehavior::className(),
                'relations' => [
                    'product_ids' => 'products',
                ],
            ],
        ]);
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'country_id', 'views', 'count_of_months', 'daily_budget', 'created_at', 'updated_at', 'position'], 'integer'],
            [['cost'], 'double'],
            [['status', 'published', 'deleted'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [['count_of_months', 'daily_budget', 'cost'], 'default', 'value' => '0'],
            [['city_ids', 'product_ids'], 'each', 'rule' => ['integer']],
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
            'position' => ['position'],
            'backend' => [
                'user_id',
                'country_id',
                'views',
                'count_of_months',
                'daily_budget',
                'cost',
                'status',
                'published',
                'deleted',
                'city_ids',
                'product_ids'
            ],
            'frontend' => [
                'user_id',
                'country_id',
                'views',
                'count_of_months',
                'daily_budget',
                'cost',
                'status',
                'published',
                'deleted',
                'city_ids',
                'product_ids'
            ],
        ];
    }

    /**
     * @return bool
     */
    public function beforeValidate()
    {
        $cities = [];
        foreach ($this->city_ids as $country) {
            if ($country) {
                $cities = ArrayHelper::merge($cities, $country);
            }
        }

        $this->city_ids = $cities;

        return parent::beforeValidate();
    }

    public function beforeSave($insert)
    {
        if ($this->product_ids && $this->id) {
            FactoryPromotionRelProduct::deleteAll('promotion_id = :id', [':id' => $this->id]);
        }

        return parent::beforeSave($insert);
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User'),
            'country_id' => Yii::t('app', 'Country'),
            'views' => Yii::t('app', 'Count of views'),
            'count_of_months' => 'Кол-во месяцев',
            'daily_budget' => 'Дневной бюджет',
            'cost' => Yii::t('app', 'Cost'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Create time'),
            'updated_at' => Yii::t('app', 'Update time'),
            'published' => Yii::t('app', 'Published'),
            'deleted' => Yii::t('app', 'Deleted'),
            'city_ids' => Yii::t('app', 'Cities'),
            'product_ids' => Yii::t('app', 'Products'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCities()
    {
        return $this
            ->hasMany(City::class, ['id' => 'city_id'])
            ->viaTable(FactoryPromotionRelCity::tableName(), ['promotion_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this
            ->hasMany(Product::class, ['id' => 'catalog_item_id'])
            ->viaTable(FactoryPromotionRelProduct::tableName(), ['promotion_id' => 'id']);
    }

    /**
     * @return mixed
     */
    public static function findBase()
    {
        return self::find()
            ->orderBy(self::tableName() . '.updated_at DESC');
    }

    /**
     * @return array
     */
    public static function getCountOfMonthsRange()
    {
        return [
            1 => 1 . ' ' . Yii::t('app', 'мес.'),
            2 => 2 . ' ' . Yii::t('app', 'мес.'),
            3 => 3 . ' ' . Yii::t('app', 'мес.'),
            4 => 4 . ' ' . Yii::t('app', 'мес.'),
            5 => 5 . ' ' . Yii::t('app', 'мес.'),
        ];
    }

    /**
     * @return array
     */
    public static function getCountOfViews()
    {
        return [
            1000 => [2 => 24000, 3 => 20400],
            1400 => [2 => 32000, 3 => 27200],
            1900 => [2 => 40000, 3 => 34000],
            2500 => [2 => 48000, 3 => 40800],
            3100 => [2 => 56000, 3 => 47600],
            3600 => [2 => 64000, 3 => 54400],
            4200 => [2 => 72000, 3 => 61200],
            5000 => [2 => 80000, 3 => 68000],
        ];
    }

    /**
     * @return array
     */
    public static function getDailyBudgetRange()
    {
        return [
            500 => 500 . ' ' . Yii::t('app', 'руб/день'),
            800 => 800 . ' ' . Yii::t('app', 'руб/день'),
            1000 => 1000 . ' ' . Yii::t('app', 'руб/день'),
            1500 => 1500 . ' ' . Yii::t('app', 'руб/день'),
            2000 => 2000 . ' ' . Yii::t('app', 'руб/день'),
        ];
    }
}