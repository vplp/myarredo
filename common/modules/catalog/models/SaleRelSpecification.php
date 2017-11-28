<?php

namespace common\modules\catalog\models;

use thread\app\base\models\ActiveRecord;
use common\modules\catalog\Catalog;

/**
 * Class SaleRelSpecification
 *
 * @property string $specification_id
 * @property string $sale_catalog_item_id
 * @property string $val
 *
 * @package common\modules\catalog\models
 */
class SaleRelSpecification extends ActiveRecord
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
        return [];
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSpecification()
    {
        return $this->hasOne(Specification::class, ['id' => 'specification_id']);
    }
}