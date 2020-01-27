<?php

namespace common\modules\catalog\models;

use thread\app\base\models\ActiveRecord;
use common\modules\catalog\Catalog;

/**
 * Class ProductRelSamples
 *
 * @property string $catalog_item_id
 * @property string $samples_id
 *
 * @package common\modules\catalog\models
 */
class ProductRelSamples extends ActiveRecord
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
        return '{{%catalog_samples_rel_catalog_item}}';
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
            ['samples_id', 'exist', 'targetClass' => Samples::class, 'targetAttribute' => 'id'],
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
                'samples_id',
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
            'samples_id',
        ];
    }
}
