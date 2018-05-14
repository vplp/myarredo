<?php

namespace common\modules\catalog\models;

use Yii;
//
use thread\app\base\models\ActiveRecord;
//
use common\modules\catalog\Catalog;

/**
 * Class SaleStats
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $sale_item_id
 * @property integer $country_id
 * @property integer $city_id
 * @property integer $date
 * @property string $ip
 * @property string $http_user_agent
 * @property boolean $is_bot
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @package common\modules\catalog\models
 */
class SaleStats extends ActiveRecord
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
        return '{{%catalog_sale_item_stats}}';
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
            [['is_bot'], 'in', 'range' => [0, 1]],
            [['http_user_agent'], 'string', 'max' => 512],
            [
                [
                    'user_id',
                    'sale_item_id',
                    'country_id',
                    'city_id',
                    'date',
                    'create_time',
                    'update_time',
                ],
                'integer'
            ],
            [['is_bot'], 'default', 'value' => 0]
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
                'sale_item_id',
                'country_id',
                'city_id',
                'date',
                'ip',
                'http_user_agent',
                'is_bot',
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
            'sale_item_id' => Yii::t('app', 'Product'),
            'country_id',
            'city_id',
            'date',
            'ip',
            'http_user_agent',
            'is_bot',
            'created_at' => Yii::t('app', 'Create time'),
            'updated_at' => Yii::t('app', 'Update time'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSale()
    {
        return $this->hasOne(Sale::class, ['id' => 'sale_item_id']);
    }

    /**
     * @return mixed
     */
    public static function findBase()
    {
        return self::find()
            ->select([
                self::tableName() . '.sale_item_id',
                'count(' . self::tableName() . '.sale_item_id) as count'
            ])
            ->innerJoinWith(["sale"])
            ->innerJoinWith(["sale.lang"])
            ->groupBy(self::tableName() . '.id')
            ->orderBy('count DESC');
    }
}