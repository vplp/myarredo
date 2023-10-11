<?php

namespace common\modules\catalog\models;

use thread\app\base\models\ActiveRecord;
use common\modules\catalog\Catalog;

/**
 * Class SaleRelCategory
 *
 * @property string $sale_item_id
 * @property string $group_id
 *
 * @package common\modules\catalog\models
 */
class SaleRelCategory extends ActiveRecord
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
        return '{{%catalog_sale_item_rel_catalog_group}}';
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
            ['sale_item_id', 'exist', 'targetClass' => Sale::class, 'targetAttribute' => 'id'],
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
                'sale_item_id',
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
            'sale_item_id',
            'group_id',
        ];
    }
}