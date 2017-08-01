<?php

namespace common\modules\catalog\models;

use thread\app\base\models\ActiveRecord;
use common\modules\catalog\Catalog;

/**
 * Class SpecificationRelSale
 *
 * @property string $specification_id
 * @property string $sale_catalog_item_id
 * @property string $val
 *
 * @package common\modules\catalog\models
 */
class SpecificationRelSale extends ActiveRecord
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
        return '{{%catalog_specification_sale_value}}';
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
            ['specification_id', 'exist', 'targetClass' => Specification::class, 'targetAttribute' => 'id'],
            ['sale_catalog_item_id', 'exist', 'targetClass' => Sale::class, 'targetAttribute' => 'id'],
            [['val'], 'integer'],
            [['val'], 'default', 'value' => '0']
        ];
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return [
            'backend' => [
                'specification_id',
                'sale_catalog_item_id',
                'val'
            ],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'specification_id',
            'sale_catalog_item_id',
            'val'
        ];
    }
}