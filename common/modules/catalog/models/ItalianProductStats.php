<?php

namespace common\modules\catalog\models;

use Yii;
//
use thread\app\base\models\ActiveRecord;
//
use common\modules\catalog\Catalog;

/**
 * Class ItalianProductStats
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $item_id
 * @property integer $country_id
 * @property integer $city_id
 * @property string $ip
 * @property string $http_user_agent
 * @property boolean $is_bot
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @package common\modules\catalog\models
 */
class ItalianProductStats extends ActiveRecord
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
        return '{{%catalog_italian_item_stats}}';
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
                    'item_id',
                    'country_id',
                    'city_id',
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
                'item_id',
                'country_id',
                'city_id',
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
            'item_id' => Yii::t('app', 'Product'),
            'country_id',
            'city_id',
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
    public function getItalianProduct()
    {
        return $this->hasOne(ItalianProduct::class, ['id' => 'item_id']);
    }

    /**
     * @return mixed
     */
    public static function findBase()
    {
        return self::find()
            ->select([
                self::tableName() . '.item_id',
                'count(' . self::tableName() . '.item_id) as count'
            ])
            ->innerJoinWith(["italianProduct"])
            ->innerJoinWith(["italianProduct.lang"])
            ->groupBy(self::tableName() . '.id')
            ->orderBy('count DESC');
    }
}