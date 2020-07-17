<?php

namespace common\modules\catalog\models;

use common\modules\catalog\Catalog;
use thread\app\base\models\ActiveRecord;

/**
 * Class ProductRelCategory
 *
 * @property int $catalog_item_id
 * @property int $group_id
 *
 * @package common\modules\catalog\models
 */
class ProductRelCategory extends ActiveRecord
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
        return '{{%catalog_item_rel_catalog_group}}';
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
            ['group_id', 'exist', 'targetClass' => Category::class, 'targetAttribute' => 'id'],
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
                'group_id',
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
            'group_id',
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
            ->indexBy('group_id')
            ->select('group_id, count(group_id) as count')
            ->groupBy('group_id')
            ->andWhere(['in', 'catalog_item_id', $subQuery])
            ->all();
    }
}
