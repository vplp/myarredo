<?php

namespace common\modules\catalog\models;

use thread\app\base\models\ActiveRecord;
use common\modules\catalog\Catalog;

/**
 * Class ProductRelSpecification
 *
 * @property string $specification_id
 * @property string $catalog_item_id
 * @property string $val
 *
 * @package common\modules\catalog\models
 */
class ProductRelSpecification extends ActiveRecord
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
        return '{{%catalog_specification_value}}';
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
            ['catalog_item_id', 'exist', 'targetClass' => Product::class, 'targetAttribute' => 'id'],
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
                'catalog_item_id',
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
            'catalog_item_id',
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'catalog_item_id']);
    }

    /**
     * @param $specification_id
     * @return mixed
     */
    public static function getCounts($specification_id)
    {
        return self::find()
            ->asArray()
            ->indexBy('specification_id')
            ->select('specification_id, count(specification_id) as count')
            ->groupBy('specification_id')
            ->andWhere(['in', 'specification_id', $specification_id])
            ->all();
    }
}
