<?php

namespace common\modules\catalog\models;

use common\modules\catalog\Catalog;
//
use thread\app\base\models\ActiveRecord;

/**
 * Class ColorsRelItalianProduct
 *
 * @property int $item_id
 * @property int $color_id
 *
 * @package common\modules\catalog\models
 */
class ColorsRelItalianProduct extends ActiveRecord
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
        return '{{%catalog_colors_rel_catalog_italian_item}}';
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
            ['item_id', 'exist', 'targetClass' => ItalianProduct::class, 'targetAttribute' => 'id'],
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
                'item_id',
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
            'item_id',
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
            ->andWhere(['in', 'item_id', $subQuery])
            ->all();
    }
}
