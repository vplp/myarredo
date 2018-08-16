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
            [['user_id', 'city_ids', 'product_ids'], 'required'],
            [['user_id', 'count_of_months', 'daily_budget', 'created_at', 'updated_at', 'position'], 'integer'],
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
            $cities = ArrayHelper::merge($cities, $country);
        }

        $this->city_ids = $cities;

        return parent::beforeValidate();
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User'),
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
            1 => Yii::t('app','1 мес'),
            2 => Yii::t('app','2 мес'),
            3 => Yii::t('app','3 мес'),
            4 => Yii::t('app','4 мес'),
            5 => Yii::t('app','5 мес'),
        ];
    }

    /**
     * @return array
     */
    public static function getDailyBudgetRange()
    {
        return [
            500 => Yii::t('app','500 руб/день'),
            800 => Yii::t('app','800 руб/день'),
            1000 => Yii::t('app','1000 руб/день'),
            1500 => Yii::t('app','1500 руб/день'),
            2000 => Yii::t('app','2000 руб/день'),
        ];
    }
}