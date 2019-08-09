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
use common\helpers\Inflector;
use common\modules\catalog\Catalog;
use common\modules\user\models\{
    Group as UserGroup, User
};

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
 * @property integer $is_composition
 * @property string $alias
 * @property string $article
 * @property float $price
 * @property float $volume
 * @property float $factory_price
 * @property float $price_from
 * @property string $currency
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
 * @property integer $mark
 * @property string $language_editing
 * @property integer $mark1
 * @property integer $in_stock
 *
 * @property ProductLang $title
 * @property ProductLang $lang
 * @property ProductRelCategory[] $category
 * @property ProductRelSubTypes[] $subTypes
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
                    'subtypes_ids' => 'subTypes',
                    'samples_ids' => 'samples',
                    'colors_ids' => 'colors',
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
            [['factory_id', 'catalog_type_id'], 'required', 'on' => 'backend'],
            [
                [
                    'catalog_type_id',
                    'user_id',
                    'factory_id',
                    'collections_id',
                    'created_at',
                    'updated_at',
                    'position'
                ],
                'integer'
            ],
            [[/*'price',*/ 'volume', 'factory_price', 'price_from'], 'double'],
            [[/*'price',*/ 'volume', 'factory_price', 'price_from'], 'default', 'value' => 0.00],
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
                    'moderation',
                    'mark',
                    'mark1',
                    'in_stock'
                ],
                'in',
                'range' => array_keys(static::statusKeyRange())
            ],
            [['country_code', 'user', 'alias', 'default_title', 'image_link'], 'string', 'max' => 255],
            [['gallery_image'], 'string', 'max' => 1024],
            [['article'], 'string', 'max' => 100],
            [['alias'], 'unique'],
            [['catalog_type_id', 'collections_id', 'position'], 'default', 'value' => '0'],
            [['country_code'], 'default', 'value' => '//'],
            [['article'], 'default', 'value' => ''],
            [
                [
                    'category_ids',
                    'subtypes_ids',
                    'samples_ids',
                    'colors_ids',
                    'factory_catalogs_files_ids',
                    'factory_prices_files_ids'
                ],
                'each',
                'rule' => ['integer']
            ],
            [['category_ids'], 'required'],
            [['currency'], 'in', 'range' => array_keys(static::currencyRange())],
            [['currency'], 'default', 'value' => 'EUR'],
            [['language_editing'], 'string', 'max' => 5],
            [['language_editing'], 'default', 'value' => ''],
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
            'in_stock' => ['in_stock'],
            'position' => ['position'],
            'setImages' => ['image_link', 'gallery_image'],
            'setAlias' => ['alias', 'mark'],
            'setMark' => ['mark'],
            'setMark1' => ['mark1'],
            'backend' => [
                'catalog_type_id',
                'user_id',
                'factory_id',
                'collections_id',
                'image_link',
                'gallery_image',
                'created_at',
                'updated_at',
                'position',
                'volume',
                'factory_price',
                'price_from',
                'currency',
                'is_composition',
                'popular',
                'novelty',
                'bestseller',
                'onmain',
                'published',
                'deleted',
                'removed',
                'in_stock',
                'moderation',
                'country_code',
                'user',
                'alias',
                'default_title',
                'article',
                'category_ids',
                'subtypes_ids',
                'samples_ids',
                'colors_ids',
                'factory_catalogs_files_ids',
                'factory_prices_files_ids',
                'mark',
                'language_editing',
                'mark1'
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
            'article' => Yii::t('app', 'Артикул'),
            //'price' => Yii::t('app', 'Price'),
            'volume' => Yii::t('app', 'Volume'),
            'factory_price' => Yii::t('app', 'Factory price'),
            'price_from' => Yii::t('app', 'Price from'),
            'currency' => Yii::t('app', 'Currency'),
            'removed' => 'Снят с производства',
            'in_stock' => 'Под заказ | В наличии',
            'factory_id' => Yii::t('app', 'Factory'),
            'collections_id' => Yii::t('app', 'Collections'),
            'catalog_type_id' => Yii::t('app', 'Catalog type'),
            'popular' => 'Популярное',
            'user' => 'Кто изменил',
            'image_link' => Yii::t('app', 'Image link'),
            'gallery_image' => Yii::t('app', 'Gallery image'),
            'novelty' => Yii::t('app', 'Novelty'),
            'moderation' => 'На проверке',
            'bestseller' => Yii::t('app', 'Bestseller'),
            'onmain' => Yii::t('app', 'On main'),
            'position' => Yii::t('app', 'Position'),
            'created_at' => Yii::t('app', 'Create time'),
            'updated_at' => Yii::t('app', 'Update time'),
            'published' => Yii::t('app', 'Published'),
            'deleted' => Yii::t('app', 'Deleted'),
            'category_ids' => Yii::t('app', 'Category'),
            'subtypes_ids' => Yii::t('app', 'Типы'),
            'samples_ids' => Yii::t('app', 'Samples'),
            'colors_ids' => Yii::t('app', 'Colors'),
            'factory_catalogs_files_ids' => Yii::t('app', 'Factory catalogs files'),
            'factory_prices_files_ids' => Yii::t('app', 'Factory prices files'),
            'specification_value_ids',
            'mark',
            'language_editing',
            'mark1'
        ];
    }

    /**
     * @param bool $insert
     * @return bool
     * @throws \Throwable
     */
    public function beforeSave($insert)
    {
        if ($this->alias == '' && in_array($this->scenario, ['backend', 'setAlias', 'frontend'])) {
            $this->alias = (!empty($this->types) ? $this->types->alias : '')
                . (!empty($this->factory) ? ' ' . $this->factory->alias : '')
                . (!empty($this->collection) ? ' ' . $this->collection->title : '')
                . (($this->article) ? ' ' . $this->article : '');

            if ($this->id) {
                $this->alias = $this->id . ' ' . $this->alias;
            }
        }

        if (in_array($this->scenario, ['frontend', 'backend'])) {
            $this->mark = '0';
            $this->language_editing = Yii::$app->language;
            $this->mark1 = '0';
        }

        if (YII_ENV_PROD) {
            /** @var Catalog $module */
            $module = Yii::$app->getModule('catalog');

            $path = $module->getProductUploadPath();
            $url = $module->getProductUploadUrl();

            $images = explode(',', $this->gallery_image);

            $imagesSources = [];

            foreach ($images as $image) {
                if (is_file($path . '/' . $image)) {
                    $imagesSources[] = $image;
                }
            }

            $this->gallery_image = implode(',', $imagesSources);
        }

        return parent::beforeSave($insert);
    }

    /**
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        if ($this->scenario == 'backend') {
            // delete relation ProductRelSpecification
            ProductRelSpecification::deleteAll(['catalog_item_id' => $this->id]);

            // save relation ProductRelSpecification
            if (Yii::$app->request->getBodyParam('SpecificationValue')) {
                foreach (Yii::$app->request->getBodyParam('SpecificationValue') as $specification_id => $val) {
                    if ($val) {
                        $model = new ProductRelSpecification();
                        $model->setScenario('backend');
                        $model->catalog_item_id = $this->id;
                        $model->specification_id = $specification_id;
                        $model->val = $val;
                        $model->save();
                    }
                }
            }

            // Update Product Count In to Group
            Category::updateEnabledProductCounts();
        }

        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * @return array
     */
    public static function currencyRange()
    {
        return [
            'EUR' => 'EUR',
            'RUB' => 'RUB'
        ];
    }

    /**
     * @return mixed
     */
    public static function findBase()
    {
        return self::find()
            ->joinWith(['lang'])
            ->orderBy(self::tableName() . '.updated_at DESC');
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
     * Title
     *
     * @return string
     */
    public function getTitle()
    {
        $title = $this->lang->title ?? '{}';

        return $title;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(ProductLang::class, ['rid' => 'id']);
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
                ? substr($this->gallery_image, 1)
                : $this->gallery_image;

            $images = explode(',', $this->gallery_image);
        }

        $imagesSources = [];

        foreach ($images as $key => $image) {
            if (is_file($path . '/' . $image)) {
                $imagesSources[] = $url . '/' . $image;
            } else {
                unset($images[$key]);
            }
        }

        return $imagesSources;
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getCategory()
    {
        return $this
            ->hasMany(Category::class, ['id' => 'group_id'])
            ->viaTable(ProductRelCategory::tableName(), ['catalog_item_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getSubTypes()
    {
        return $this
            ->hasMany(SubTypes::class, ['id' => 'subtype_id'])
            ->viaTable(ProductRelSubTypes::tableName(), ['item_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getSamples()
    {
        return $this
            ->hasMany(Samples::class, ['id' => 'samples_id'])
            ->viaTable(ProductRelSamples::tableName(), ['catalog_item_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getColors()
    {
        return $this
            ->hasMany(Colors::class, ['id' => 'color_id'])
            ->viaTable(ColorsRelProduct::tableName(), ['item_id' => 'id']);
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
     * @throws \yii\base\InvalidConfigException
     */
    public function getFactoryCatalogsFiles()
    {
        return $this
            ->hasMany(FactoryCatalogsFiles::class, ['id' => 'factory_file_id'])
            ->viaTable(ProductRelFactoryCatalogsFiles::tableName(), ['catalog_item_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getFactoryPricesFiles()
    {
        return $this
            ->hasMany(FactoryPricesFiles::class, ['id' => 'factory_file_id'])
            ->viaTable(ProductRelFactoryPricesFiles::tableName(), ['catalog_item_id' => 'id']);
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
     * @throws \yii\base\InvalidConfigException
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
     * @throws \yii\base\InvalidConfigException
     */
    public function getUserGroup()
    {
        return $this->hasOne(UserGroup::class, ['id' => 'group_id'])
            ->viaTable(User::tableName(), ['id' => 'user_id']);
    }
}
