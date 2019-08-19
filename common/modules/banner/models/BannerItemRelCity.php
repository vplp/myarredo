<?php

namespace common\modules\banner\models;

use common\modules\location\models\City;
//
use thread\app\base\models\ActiveRecord;

/**
 * Class BannerItemRelCity
 *
 * @property int $item_id
 * @property int $city_id
 *
 * @package common\modules\banner\models
 */
class BannerItemRelCity extends ActiveRecord
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
        return '{{%banner_item_rel_city}}';
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
                'item_id',
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
            'item_id',
            'city_id',
        ];
    }
}
