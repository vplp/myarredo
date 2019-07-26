<?php

namespace common\modules\catalog\models;

use Yii;
use yii\behaviors\AttributeBehavior;
use yii\helpers\{
    ArrayHelper
};
use voskobovich\behaviors\ManyToManyBehavior;
//
use thread\app\base\models\ActiveRecord;
//
use common\helpers\Inflector;
use common\modules\catalog\Catalog;

/**
 * Class Types
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $alias
 * @property integer $position
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $published
 * @property integer $deleted
 *
 * @property TypesLang $lang
 * @property TypesRelCategory $category
 * @property Product $product
 * @property Sale $sale
 * @property ItalianProduct $italianProduct
 *
 * @package common\modules\catalog\models
 */
class Types extends ActiveRecord
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
        return '{{%catalog_type}}';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            [
                'class' => ManyToManyBehavior::className(),
                'relations' => [
                    'category_ids' => 'category',
                ],
            ],
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'alias',
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'alias',
                ],
                'value' => function ($event) {
                    return Inflector::slug($this->alias);
                },
            ],
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
            [['published', 'deleted'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [['alias'], 'string', 'max' => 255],
            [['alias'], 'unique'],
            [['parent_id', 'position'], 'default', 'value' => '0'],
            [['category_ids'], 'each', 'rule' => ['integer']],
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
            'backend' => ['parent_id', 'alias', 'position', 'published', 'deleted', 'category_ids'],
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
            'position' => Yii::t('app', 'Position'),
            'created_at' => Yii::t('app', 'Create time'),
            'updated_at' => Yii::t('app', 'Update time'),
            'published' => Yii::t('app', 'Published'),
            'deleted' => Yii::t('app', 'Deleted'),
            'category_ids' => Yii::t('app', 'Category'),
        ];
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function getById($id)
    {
        return self::find()->byID($id)->one();
    }

    /**
     * @return mixed
     */
    public function getChildren()
    {
        return $this->hasMany(SubTypes::class, ['parent_id' => 'id']);
    }

    /**
     * @return int|string
     */
    public function getChildrenCount()
    {
        return $this->getChildren()->count();
    }

    /**
     * @return mixed
     */
    public static function findBase()
    {
        return self::find()->joinWith(['lang'])->orderBy(TypesLang::tableName() . '.title');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(TypesLang::class, ['rid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getCategory()
    {
        return $this
            ->hasMany(Category::class, ['id' => 'group_id'])
            ->viaTable(TypesRelCategory::tableName(), ['type_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasMany(Product::class, ['catalog_type_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSale()
    {
        return $this->hasMany(Sale::class, ['catalog_type_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItalianProduct()
    {
        return $this->hasMany(ItalianProduct::class, ['catalog_type_id' => 'id']);
    }
}
