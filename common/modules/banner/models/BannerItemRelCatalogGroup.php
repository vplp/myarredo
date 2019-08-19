<?php

namespace common\modules\banner\models;

use common\modules\catalog\models\Category;
use common\modules\location\models\City;
//
use thread\app\base\models\ActiveRecord;

/**
 * Class BannerItemRelCatalogGroup
 *
 * @property int $item_id
 * @property int $category_id
 *
 * @package common\modules\banner\models
 */
class BannerItemRelCatalogGroup extends ActiveRecord
{
    /**
     * @return \yii\db\Connection
     */
    public static function getDb()
    {
        return ArticlesModule::getDb();
    }

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%banner_item_rel_catalog_group}}';
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
            ['item_id', 'exist', 'targetClass' => BannerItem::class, 'targetAttribute' => 'id'],
            ['category_id', 'exist', 'targetClass' => Category::class, 'targetAttribute' => 'id'],
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
                'category_id',
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
            'category_id',
        ];
    }
}
