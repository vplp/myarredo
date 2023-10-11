<?php

namespace common\modules\catalog\models;

use Yii;
use yii\helpers\{
    ArrayHelper
};
use voskobovich\behaviors\ManyToManyBehavior;

/**
 * Class Composition
 *
 * @property CompositionLang $lang
 * @property ProductRelComposition[] $product
 *
 * @package common\modules\catalog\models
 */
class Composition extends Product
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            [
                'class' => ManyToManyBehavior::className(),
                'relations' => [
                    'product_ids' => 'product',
                    'category_ids' => 'category',
                ],
            ],
        ]);
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['factory_id'], 'required'],
            [
                [
                    'catalog_type_id',
                    'user_id',
                    'editor_id',
                    'factory_id',
                    'collections_id',
                    'created_at',
                    'updated_at',
                    'position'
                ],
                'integer'
            ],
            [['price', 'volume', 'factory_price', 'price_from'], 'double'],
            [['price', 'volume', 'factory_price', 'price_from'], 'default', 'value' => 0.00],
            [
                [
                    'is_composition',
                    'popular',
                    'novelty',
                    'bestseller',
                    'onmain',
                    'published',
                    'deleted',
                    'removed',
                    'moderation'
                ],
                'in',
                'range' => array_keys(static::statusKeyRange())
            ],
            [['country_code', 'alias', 'alias_en', 'alias_it', 'alias_de', 'alias_fr', 'alias_he', 'default_title'], 'string', 'max' => 255],
            [['article'], 'string', 'max' => 100],
            [['alias', 'alias_en', 'alias_it', 'alias_de', 'alias_fr', 'alias_he'], 'unique'],
            [['catalog_type_id', 'collections_id', 'position'], 'default', 'value' => '0'],
            [['country_code'], 'default', 'value' => '//'],
            [['article'], 'default', 'value' => ''],
            [
                ['category_ids', 'product_ids'],
                'each',
                'rule' => ['integer']
            ],
            [['category_ids'], 'required'],
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
            'popular' => ['popular'],
            'novelty' => ['novelty'],
            'bestseller' => ['bestseller'],
            'onmain' => ['onmain'],
            'removed' => ['removed'],
            'position' => ['position'],
            'backend' => [
                'catalog_type_id',
                'user_id',
                'editor_id',
                'factory_id',
                'collections_id',
                'created_at',
                'updated_at',
                'position',
                'price',
                'volume',
                'factory_price',
                'price_from',
                'is_composition',
                'popular',
                'novelty',
                'bestseller',
                'onmain',
                'image_link',
                'gallery_image',
                'published',
                'deleted',
                'removed',
                'moderation',
                'country_code',
                'alias',
                'alias_en',
                'alias_it',
                'alias_de',
                'alias_fr',
                'alias_he',
                'default_title',
                'article',
                'category_ids',
                'product_ids'
            ],
            'translation' => [
                'editor_id',
                'created_at',
                'updated_at',
                'mark',
                'language_editing',
            ],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'product_ids' => Yii::t('app', 'Product'),
        ]);
    }

    /**
     * @return mixed
     */
    public static function findBase()
    {
        return self::find()
            ->joinWith(['lang'])
            ->andWhere(['is_composition' => '1'])
            ->orderBy(self::tableName() . '.updated_at DESC');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(CompositionLang::class, ['rid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getProduct()
    {
        return $this
            ->hasMany(Product::class, ['id' => 'catalog_item_id'])
            ->viaTable(ProductRelComposition::tableName(), ['composition_id' => 'id']);
    }

    /**
     * @return null|string
     */
    public function getImageLink()
    {
        $module = Yii::$app->getModule('catalog');

        $path = $module->getProductUploadPath();
        $url = $module->getProductUploadUrl();

        $image = null;

        if (!empty($this->image_link) && is_file($path . '/' . $this->image_link)) {
            $image = $url . '/' . $this->image_link;
        }

        return $image;
    }
}
