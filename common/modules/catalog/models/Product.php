<?php

namespace common\modules\catalog\models;

use Yii;
use yii\helpers\{
    ArrayHelper
};
use yii\behaviors\AttributeBehavior;
//
use voskobovich\behaviors\ManyToManyBehavior;
//
use thread\app\base\models\ActiveRecord;
use thread\modules\shop\interfaces\Product as iProduct;
//
use common\modules\catalog\Catalog;
use common\helpers\Inflector;

/**
 * Class Product
 *
 * @property integer $id
 * @property string $country_code
 * @property integer $catalog_type_id
 * @property integer $user_id
 * @property string $user
 * @property integer $factory_id
 * @property integer $collections_id
 * @property integer $gallery_id
 * @property integer $picpath
 * @property integer $is_composition
 * @property string $alias
 * @property string $alias_old
 * @property string $article
 * @property float $price
 * @property float $volume
 * @property float $factory_price
 * @property float $price_from
 * @property float $retail_price
 * @property string $default_title
 * @property integer $popular
 * @property integer $novelty
 * @property integer $bestseller
 * @property integer $onmain
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $published
 * @property integer $deleted
 * @property integer $removed
 * @property integer $moderation
 * @property integer $position
 * @property string $image_link
 * @property string $gallery_image
 *
 * @property ProductLang $lang
 * @property ProductRelCategory[] $category
 * @property ProductRelSamples[] $samples
 * @property Factory $factory
 * @property ProductRelFactoryCatalogsFiles[] $factoryCatalogsFiles
 * @property ProductRelFactoryPricesFiles[] $factoryPricesFiles
 * @property Types $types
 * @property Collection $collection
 *
 * @package common\modules\catalog\models
 */
class Product extends ActiveRecord implements iProduct
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
        return '{{%catalog_item}}';
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
                    'samples_ids' => 'samples',
                    'factory_catalogs_files_ids' => 'factoryCatalogsFiles',
                    'factory_prices_files_ids' => 'factoryPricesFiles',
                ],
            ],
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'alias',
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'alias',
                ],
                'value' => function ($event) {
                    return Inflector::slug($this->alias, '_');
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
            [['factory_id', 'catalog_type_id'], 'required'],
            [
                [
                    'catalog_type_id',
                    'user_id',
                    'factory_id',
                    'collections_id',
                    'gallery_id',
                    'created_at',
                    'updated_at',
                    'position'
                ],
                'integer'
            ],
            [['price', 'volume', 'factory_price', 'price_from', 'retail_price'], 'double'],
            [['price', 'volume', 'factory_price', 'price_from', 'retail_price'], 'default', 'value' => 0.00],
            [
                [
                    'picpath',
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
            [['country_code', 'user', 'alias', 'alias_old', 'default_title', 'image_link'], 'string', 'max' => 255],
            [['gallery_image'], 'string', 'max' => 1024],
            [['article'], 'string', 'max' => 100],
            [['alias'], 'unique'],
            [['catalog_type_id', 'collections_id', 'position'], 'default', 'value' => '0'],
            [['country_code'], 'default', 'value' => '//'],
            [['article', 'alias_old'], 'default', 'value' => ''],
            [
                [
                    'category_ids',
                    'samples_ids',
                    'factory_catalogs_files_ids',
                    'factory_prices_files_ids'
                ],
                'each',
                'rule' => ['integer']
            ],
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
            'gallery_image' => ['gallery_image', 'picpath'],
            'backend' => [
                'catalog_type_id',
                'user_id',
                'factory_id',
                'collections_id',
                'gallery_id',
                'image_link',
                'gallery_image',
                'created_at',
                'updated_at',
                'position',
                'price',
                'volume',
                'factory_price',
                'price_from',
                'retail_price',
                'is_composition',
                'popular',
                'novelty',
                'bestseller',
                'onmain',
                'published',
                'deleted',
                'removed',
                'moderation',
                'country_code',
                'user',
                'alias',
                'alias_old',
                'default_title',
                'article',
                'category_ids',
                'samples_ids',
                'factory_catalogs_files_ids',
                'factory_prices_files_ids',
            ],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'alias' => Yii::t('app', 'Alias'),
            'country_code' => 'Показывать для страны',
            'article' => 'Артикул',
            'price' => 'Цена',
            'volume' => 'Объем',
            'factory_price' => 'Цена фибрики',
            'price_from' => 'Цена от',
            'removed' => 'Снят с производства',
            'factory_id' => 'Фабрика',
            'collections_id' => 'Коллекция',
            'catalog_type_id' => 'Тип предмета',
            'popular' => 'Популярное',
            'user' => 'Кто изменил',
            'picpath' => 'picpath',
            'image_link' => Yii::t('app', 'Image link'),
            'gallery_image' => Yii::t('app', 'Gallery image'),
            'novelty' => 'Новинка',
            'moderation' => 'На проверке',
            'bestseller' => 'Бестселлер',
            'onmain' => 'На главную',
            'position' => Yii::t('app', 'Position'),
            'created_at' => Yii::t('app', 'Create time'),
            'updated_at' => Yii::t('app', 'Update time'),
            'published' => Yii::t('app', 'Published'),
            'deleted' => Yii::t('app', 'Deleted'),
            'category_ids' => Yii::t('app', 'Category'),
            'samples_ids' => Yii::t('app', 'Samples'),
            'factory_catalogs_files_ids' => Yii::t('app', 'Factory catalogs files'),
            'factory_prices_files_ids' => Yii::t('app', 'Factory prices files'),
            'specification_value_ids',
        ];
    }

    /**
     * @return mixed
     */
    public static function findBase()
    {
        return self::find()
            ->innerJoinWith(['lang'])
            ->orderBy('updated_at DESC');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(ProductLang::class, ['rid' => 'id']);
    }

    /**
     * @return null|string
     */
    public function getImageLink()
    {
        /** @var Catalog $module */
        $module = Yii::$app->getModule('catalog');

        $path = $module->getProductUploadPath();
        $url = $module->getProductUploadUrl();

        $image = null;

        if (!empty($this->image_link) && is_file($path . '/' . $this->image_link)) {
            $image = $url . '/' . $this->image_link;
        }

        return $image;
    }

    /**
     * @return array
     */
    public function getGalleryImage()
    {
        /** @var Catalog $module */
        $module = Yii::$app->getModule('catalog');

        $path = $module->getProductUploadPath();
        $url = $module->getProductUploadUrl();

        $images = [];

        if (!empty($this->gallery_image)) {
            $this->gallery_image = $this->gallery_image[0] == ','
                ? substr($this->gallery_image,1)
                : $this->gallery_image;

            $images = explode(',', $this->gallery_image);
        }

        $imagesSources = [];

        foreach ($images as $image) {
            if (file_exists($path . '/' . $image)) {
                $imagesSources[] = $url . '/' . $image;
            }
        }

        return $imagesSources;
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this
            ->hasMany(Category::class, ['id' => 'group_id'])
            ->viaTable(ProductRelCategory::tableName(), ['catalog_item_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSamples()
    {
        return $this
            ->hasMany(Samples::class, ['id' => 'samples_id'])
            ->viaTable(ProductRelSamples::tableName(), ['catalog_item_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFactory()
    {
        return $this->hasOne(Factory::class, ['id' => 'factory_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTypes()
    {
        return $this->hasOne(Types::class, ['id' => 'catalog_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCollection()
    {
        return $this->hasOne(Collection::class, ['id' => 'collections_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFactoryCatalogsFiles()
    {
        return $this
            ->hasMany(FactoryFile::class, ['id' => 'factory_file_id'])
            ->viaTable(ProductRelFactoryCatalogsFiles::tableName(), ['catalog_item_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFactoryPricesFiles()
    {
        return $this
            ->hasMany(FactoryFile::class, ['id' => 'factory_file_id'])
            ->viaTable(ProductRelFactoryPricesFiles::tableName(), ['catalog_item_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSpecification()
    {
        return $this
            ->hasMany(Specification::class, ['id' => 'specification_id'])
            ->viaTable(ProductRelSpecification::tableName(), ['catalog_item_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSpecificationValue()
    {
        return $this
            ->hasMany(ProductRelSpecification::class, ['catalog_item_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompositionProduct()
    {
        return $this
            ->hasMany(Product::class, ['id' => 'catalog_item_id'])
            ->viaTable(ProductRelComposition::tableName(), ['composition_id' => 'id']);
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function findByID($id)
    {
        return self::findBase()->byID($id)->one();
    }

    /**
     * @param $ids
     * @return array
     */
    public static function findByIDs($ids): array
    {
        return self::findBase()->andWhere(['IN', 'id', array_unique($ids)])->all();
    }

    /**
     * Price
     *
     * @return mixed|null
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Discount
     *
     * @return int
     */
    public function getDiscount()
    {
        return 0;
    }
}
