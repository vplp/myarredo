<?php

namespace common\modules\catalog\models;

use thread\app\base\models\ActiveRecord;
//
use common\modules\catalog\Catalog;

/**
 * Class ProductRelTypes
 *
 * @property string $item_id
 * @property string $type_id
 *
 * @package common\modules\catalog\models
 */
class ProductRelTypes extends ActiveRecord
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
        return '{{%catalog_item_rel_catalog_type}}';
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
            ['item_id', 'exist', 'targetClass' => Product::class, 'targetAttribute' => 'id'],
            ['type_id', 'exist', 'targetClass' => Types::class, 'targetAttribute' => 'id'],
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
                'type_id',
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
            'type_id',
        ];
    }
}
