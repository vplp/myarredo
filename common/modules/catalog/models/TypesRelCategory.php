<?php

namespace common\modules\catalog\models;

use thread\app\base\models\ActiveRecord;
use common\modules\catalog\Catalog;

/**
 * Class TypesRelCategory
 *
 * @property string $type_id
 * @property string $group_id
 * @property string $order
 *
 * @package common\modules\catalog\models
 */
class TypesRelCategory extends ActiveRecord
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
        return '{{%catalog_type_rel_catalog_group}}';
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
            ['type_id', 'exist', 'targetClass' => Types::class, 'targetAttribute' => 'id'],
            ['group_id', 'exist', 'targetClass' => Category::class, 'targetAttribute' => 'id'],
            [['order'], 'integer'],
            [['order'], 'default', 'value' => '0']
        ];
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return [
            'backend' => [
                'type_id',
                'group_id',
                'order'
            ],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'type_id',
            'group_id',
            'order'
        ];
    }
}