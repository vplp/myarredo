<?php

namespace common\modules\catalog\models;

use Yii;
//
use thread\app\base\models\ActiveRecord;
//
use common\modules\catalog\Catalog;

/**
 * Class ProductStats
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $product_id
 * @property integer $city_id
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @package common\modules\catalog\models
 */
class ProductStats extends ActiveRecord
{
    public $count;

    /**
     * @return null|object|string
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
        return '{{%catalog_item_stats}}';
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
                    'user_id',
                    'product_id',
                    'city_id',
                    'create_time',
                    'update_time'
                ],
                'integer'
            ],
            [['position'], 'default', 'value' => 0]
        ];
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return [
            'frontend' => [
                'user_id',
                'product_id',
                'city_id',
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
            'user_id' => Yii::t('app', 'User'),
            'product_id' => Yii::t('app', 'Product'),
            'city_id' => Yii::t('app', 'City'),
            'created_at' => Yii::t('app', 'Create time'),
            'updated_at' => Yii::t('app', 'Update time'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }

    /**
     * @return mixed
     */
    public static function findBase()
    {
        return self::find()
            ->select([
                self::tableName() . '.product_id',
                'count(' . self::tableName() . '.product_id) as count'
            ])
            ->innerJoinWith(["product"])
            ->innerJoinWith(["product.lang"])
            ->groupBy(self::tableName() . '.product_id')
            ->orderBy('count DESC');
    }
}