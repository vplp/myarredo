<?php

namespace common\modules\catalog\models;

use thread\app\base\models\ActiveRecord;
//
use common\modules\catalog\Catalog;

/**
 * Class FactoryPromotionRelProduct
 *
 * @property string $promotion_id
 * @property string $catalog_item_id
 *
 * @package common\modules\catalog\models
 */
class FactoryPromotionRelProduct extends ActiveRecord
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
        return '{{%catalog_factory_promotion_rel_catalog_item}}';
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
            ['catalog_item_id', 'exist', 'targetClass' => Product::class, 'targetAttribute' => 'id'],
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
                'catalog_item_id',
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
            'catalog_item_id',
        ];
    }
}