<?php

namespace common\modules\catalog\models;

use common\modules\catalog\Catalog;
//
use thread\app\base\models\ActiveRecord;

/**
 * Class ProductRelColors
 *
 * @property int $catalog_item_id
 * @property int $color_id
 *
 * @package common\modules\catalog\models
 */
class ProductRelColors extends ActiveRecord
{
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
        return '{{%catalog_colors_rel_catalog_item}}';
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
            ['catalog_item_id', 'exist', 'targetClass' => Product::class, 'targetAttribute' => 'id'],
            ['color_id', 'exist', 'targetClass' => Colors::class, 'targetAttribute' => 'id'],
        ];
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return [
            'backend' => [
                'catalog_item_id',
                'color_id',
            ],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'catalog_item_id',
            'color_id',
        ];
    }

    /**
     * @param $subQuery
     * @return mixed
     */
    public static function getCounts($subQuery)
    {
        return self::find()
            ->asArray()
            ->indexBy('color_id')
            ->select('color_id, count(color_id) as count')
            ->groupBy('color_id')
            ->andWhere(['in', 'catalog_item_id', $subQuery])
            ->all();
    }
}
