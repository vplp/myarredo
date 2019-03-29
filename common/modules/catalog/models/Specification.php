<?php

namespace common\modules\catalog\models;

use Yii;
use yii\helpers\{
    ArrayHelper
};
use thread\app\base\models\ActiveRecord;
use common\modules\catalog\Catalog;

/**
 * Class Specification
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $alias
 * @property integer $type
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $published
 * @property integer $deleted
 * @property integer $position
 * @property integer $readonly
 *
 * @property SpecificationLang $lang
 *
 * @package common\modules\catalog\models
 */
class Specification extends ActiveRecord
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
        return '{{%catalog_specification}}';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [

        ]);
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['alias'], 'required'],
            [['parent_id', 'created_at', 'updated_at', 'position'], 'integer'],
            [['type', 'published', 'deleted', 'readonly'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [['alias'], 'string', 'max' => 255],
            [['alias'], 'unique'],
            [['position'], 'default', 'value' => '0']
        ];
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return [
            'published' => ['published'],
            'deleted' => ['deleted'],
            'position' => ['position'],
            'backend' => ['parent_id', 'alias', 'type', 'position', 'published', 'deleted'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'parent_id' => Yii::t('app', 'Parent'),
            'alias' => Yii::t('app', 'Alias'),
            'type' => 'Текстовое поле',
            'position' => Yii::t('app', 'Position'),
            'created_at' => Yii::t('app', 'Create time'),
            'updated_at' => Yii::t('app', 'Update time'),
            'published' => Yii::t('app', 'Published'),
            'deleted' => Yii::t('app', 'Deleted'),
            'readonly',
        ];
    }

    /**
     * @return mixed
     */
    public static function findBase()
    {
        return self::find()
            ->joinWith(['lang'])
            ->orderBy(self::tableName() . '.position');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(SpecificationLang::class, ['rid' => 'id']);
    }

    /**
     * @return mixed
     */
    public function getChildren()
    {
        return $this->hasMany(self::class, ['parent_id' => 'id']);
    }

    /**
     * @return mixed
     */
    public function getParent()
    {
        return $this->hasOne(self::class, ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this
            ->hasMany(Product::class, ['id' => 'catalog_item_id'])
            ->viaTable(ProductRelSpecification::tableName(), ['specification_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSale()
    {
        return $this
            ->hasMany(Sale::class, ['id' => 'sale_catalog_item_id'])
            ->viaTable(SaleRelSpecification::tableName(), ['specification_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItalianProduct()
    {
        return $this
            ->hasMany(ItalianProduct::class, ['id' => 'item_id'])
            ->viaTable(ItalianProductRelSpecification::tableName(), ['specification_id' => 'id']);
    }
}
