<?php

namespace common\modules\catalog\models;

use thread\app\base\models\ActiveRecord;
use common\modules\catalog\Catalog;
use common\modules\location\models\City;

/**
 * Class FactoryPromotionRelCity
 *
 * @property string $promotion_id
 * @property string $city_id
 *
 * @package common\modules\catalog\models
 */
class FactoryPromotionRelCity extends ActiveRecord
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
        return '{{%catalog_factory_promotion_rel_city}}';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [];
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['promotion_id', 'exist', 'targetClass' => FactoryPromotion::class, 'targetAttribute' => 'id'],
            ['city_id', 'exist', 'targetClass' => City::class, 'targetAttribute' => 'id'],
        ];
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return [
            'backend' => [
                'promotion_id',
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
            'promotion_id',
            'city_id',
        ];
    }
}
