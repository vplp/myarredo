<?php

namespace common\modules\catalog\models;

use thread\app\base\models\ActiveRecord;
//
use common\modules\catalog\Catalog;

/**
 * Class SaleRelSubTypes
 *
 * @property string $item_id
 * @property string $subtype_id
 *
 * @package common\modules\catalog\models
 */
class SaleRelSubTypes extends ActiveRecord
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
        return '{{%catalog_sale_item_rel_catalog_subtypes}}';
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
            ['item_id', 'exist', 'targetClass' => Sale::class, 'targetAttribute' => 'id'],
            ['subtype_id', 'exist', 'targetClass' => SubTypes::class, 'targetAttribute' => 'id'],
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
                'subtype_id',
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
            'subtype_id',
        ];
    }
}
