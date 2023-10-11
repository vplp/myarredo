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
 * @property string $val2
 * @property string $val3
 * @property string $val4
 * @property string $val5
 * @property string $val6
 * @property string $val7
 * @property string $val8
 * @property string $val9
 * @property string $val10
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
            [['val', 'val2', 'val3', 'val4', 'val5', 'val6', 'val7', 'val8', 'val9', 'val10'], 'integer'],
            [['val', 'val2', 'val3', 'val4', 'val5', 'val6', 'val7', 'val8', 'val9', 'val10'], 'default', 'value' => '0']
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
                'val',
                'val2',
                'val3',
                'val4',
                'val5',
                'val6',
                'val7',
                'val8',
                'val9',
                'val10',
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
            'val',
            'val2',
            'val3',
            'val4',
            'val5',
            'val6',
            'val7',
            'val8',
            'val9',
            'val10'
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
