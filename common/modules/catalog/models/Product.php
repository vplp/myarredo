<?php

namespace common\modules\catalog\models;

use common\modules\location\models\City;
use Yii;
use yii\helpers\{
    ArrayHelper
};
use yii\behaviors\AttributeBehavior;
use voskobovich\behaviors\ManyToManyBehavior;
use thread\app\base\models\ActiveRecord;
use thread\modules\shop\interfaces\Product as iProduct;
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
 * @property integer $editor_id
 * @property integer $factory_id
 * @property integer $collections_id
 * @property integer $is_composition
 * @property string $alias
 * @property string $alias_en
 * @property string $alias_it
 * @property string $alias_de
 * @property string $alias_fr
 * @property string $alias_he
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
 * @property integer $mark2
 * @property integer $mark3
 * @property integer $in_stock
 * @property integer $time_promotion_in_catalog
 * @property integer $time_promotion_in_category
 * @property integer $time_vip_promotion_in_catalog
 * @property integer $time_vip_promotion_in_category
 * @property array $category_ids
 *
 * @property ProductLang $title
 * @property ProductLang $lang
 * @property ProductJson $json
 * @property Category[] $category
 * @property SubTypes[] $subTypes
 * @property Samples[] $samples
 * @property User $editor
 * @property Factory $factory
 * @property Types $types
 * @property Collection $collection
 * @property ProductNoveltyRelCity $noveltyRelCities
 * @property ProductRelSpecification $specificationValue
 * @property ProductRelFactoryCatalogsFiles[] $factoryCatalogsFiles
 * @property ProductRelFactoryPricesFiles[] $factoryPricesFiles
 *
 * @package common\modules\catalog\models
 */
class Product extends ActiveRecord implements iProduct
{
    public $novelty_rel_cities = [];

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
                    'novelty_rel_cities_ids' => 'noveltyRelCities',
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
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'alias_en',
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'alias_en',
                ],
                'value' => function ($event) {
                    return Inflector::slug($this->alias_en, '_');
                },
            ],
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'alias_it',
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'alias_it',
                ],
                'value' => function ($event) {
                    return Inflector::slug($this->alias_it, '_');
                },
            ],
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'alias_de',
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'alias_de',
                ],
                'value' => function ($event) {
                    return Inflector::slug($this->alias_de, '_');
                },
            ],
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'alias_fr',
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'alias_fr',
                ],
                'value' => function ($event) {
                    return Inflector::slug($this->alias_fr, '_');
                },
            ],
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'alias_he',
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'alias_he',
                ],
                'value' => function ($event) {
                    return Inflector::slug($this->alias_he, '_');
                },
            ]
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
                    'editor_id',
                    'factory_id',
                    'collections_id',
                    'created_at',
                    'updated_at',
                    'position',
                    'time_promotion_in_catalog',
                    'time_promotion_in_category',
                    'time_vip_promotion_in_catalog',
                    'time_vip_promotion_in_category'
                ],
                'integer'
            ],
            [['volume', 'factory_price', 'price_from'], 'double'],
            [['volume', 'factory_price', 'price_from'], 'default', 'value' => 0.00],
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
                    'mark2',
                    'mark3',
                    'in_stock'
                ],
                'in',
                'range' => array_keys(static::statusKeyRange())
            ],
            [['country_code', 'alias', 'alias_en', 'alias_it', 'alias_de', 'alias_fr', 'alias_he', 'default_title', 'image_link'], 'string', 'max' => 255],
            [['gallery_image'], 'string', 'max' => 1024],
            [['article'], 'string', 'max' => 100],
            [['alias', 'alias_en', 'alias_it', 'alias_de', 'alias_fr', 'alias_he'], 'unique'],
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
                    'factory_prices_files_ids',
                    'novelty_rel_cities_ids'
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
            'setAlias' => ['alias', 'alias_en', 'alias_it', 'alias_de', 'alias_fr', 'alias_he', 'mark3'],
            'mark' => ['mark'],
            'mark1' => ['mark1'],
            'mark2' => ['mark2'],
            'mark3' => ['mark3'],
            'time_promotion_in_catalog' => ['time_promotion_in_catalog'],
            'time_promotion_in_category' => ['time_promotion_in_category'],
            'time_vip_promotion_in_catalog' => ['time_vip_promotion_in_catalog'],
            'time_vip_promotion_in_category' => ['time_vip_promotion_in_category'],
            'turbo_sale_2in1' => ['time_vip_promotion_in_catalog', 'time_vip_promotion_in_category'],
            'backend' => [
                'catalog_type_id',
                'user_id',
                'editor_id',
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
                'alias',
                'alias_en',
                'alias_it',
                'alias_de',
                'alias_fr',
                'alias_he',
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
                'mark1',
                'mark2',
                'mark3',
                'novelty_rel_cities',
                'novelty_rel_cities_ids'
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
            'user_id' => Yii::t('app', 'User'),
            'editor_id' => 'Editor',
            'alias' => Yii::t('app', 'Alias'),
            'alias_en' => 'Alias for en',
            'alias_it' => 'Alias for it',
            'alias_de' => 'Alias for de',
            'alias_fr' => 'Alias for fr',
            'alias_he' => 'Alias for he',
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
            'mark1',
            'mark2',
            'mark3',
            'language_editing',
            'time_promotion_in_catalog',
            'time_promotion_in_category',
            'time_vip_promotion_in_catalog',
            'time_vip_promotion_in_category',
            'novelty_rel_cities_ids'
        ];
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (in_array($this->scenario, ['backend'])) {
            $array = [];
            foreach ($this->novelty_rel_cities as $country) {
                if (is_array($country)) {
                    foreach ($country as $key2 => $city) {
                        $array[$city] = $city;
                    }
                }
            }

            $this->novelty_rel_cities_ids = $array;
        }

        if ($this->alias == '' && in_array($this->scenario, ['backend', 'setAlias', 'frontend'])) {
            $this->alias = (!empty($this->types) ? $this->types->alias : '')
                . (!empty($this->factory) ? ' ' . $this->factory->alias : '')
                . (($this->article) ? ' ' . $this->article : ' ' . uniqid());

            if ($this->id) {
                $this->alias = $this->id . ' ' . $this->alias;
            }
        }

        if ($this->alias_en == '' && in_array($this->scenario, ['backend', 'setAlias', 'frontend'])) {
            $this->alias_en = (!empty($this->types) ? $this->types->alias_en : '')
                . (!empty($this->factory) ? ' ' . $this->factory->alias : '')
                . (($this->article) ? ' ' . $this->article : ' ' . uniqid());

            if ($this->id) {
                $this->alias_en = $this->id . ' ' . $this->alias_en;
            }
        }

        if ($this->alias_it == '' && in_array($this->scenario, ['backend', 'setAlias', 'frontend'])) {
            $this->alias_it = (!empty($this->types) ? $this->types->alias_it : '')
                . (!empty($this->factory) ? ' ' . $this->factory->alias : '')
                . (($this->article) ? ' ' . $this->article : ' ' . uniqid());

            if ($this->id) {
                $this->alias_it = $this->id . ' ' . $this->alias_it;
            }
        }

        if ($this->alias_de == '' && in_array($this->scenario, ['backend', 'setAlias', 'frontend'])) {
            $this->alias_de = (!empty($this->types) ? $this->types->alias_de : '')
                . (!empty($this->factory) ? ' ' . $this->factory->alias : '')
                . (($this->article) ? ' ' . $this->article : ' ' . uniqid());

            if ($this->id) {
                $this->alias_de = $this->id . ' ' . $this->alias_de;
            }
        }

        if ($this->alias_fr == '' && in_array($this->scenario, ['backend', 'setAlias', 'frontend'])) {
            $this->alias_fr = (!empty($this->types) ? $this->types->alias_fr : '')
                . (!empty($this->factory) ? ' ' . $this->factory->alias : '')
                . (($this->article) ? ' ' . $this->article : ' ' . uniqid());

            if ($this->id) {
                $this->alias_fr = $this->id . ' ' . $this->alias_fr;
            }
        }

        if ($this->alias_he == '' && in_array($this->scenario, ['backend', 'setAlias', 'frontend'])) {
            $this->alias_he = (!empty($this->types) ? $this->types->alias_he : '')
                . (!empty($this->factory) ? ' ' . $this->factory->alias : '')
                . (($this->article) ? ' ' . $this->article : ' ' . uniqid());

            if ($this->id) {
                $this->alias_he = $this->id . ' ' . $this->alias_he;
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

        // не давать создавать товары без размеров
        if (in_array($this->scenario, ['frontend', 'backend']) && !$this->isNewRecord && $this->is_composition == 0 && !in_array(14, $this->category_ids)) {
            if (Yii::$app->request->getBodyParam('SpecificationValue')) {
                $data = Specification::find()->andWhere(['parent_id' => 4])->all();
                $sizeIDs = ArrayHelper::map($data, 'id', 'id');

                $count = 0;
                foreach (Yii::$app->request->getBodyParam('SpecificationValue') as $specification_id => $val) {
                    if (in_array($specification_id, $sizeIDs) && $val) {
                        ++$count;
                    }
                }

                if ($count < 2) {
                    Yii::$app->session->setFlash('error', 'Не заполнены размеры и вы не можете сохранить товар');
                    return false;
                }
            } else {
                Yii::$app->session->setFlash('error', 'Не заполнены размеры и вы не можете сохранить товар');
                return false;
            }
        }

        if (in_array($this->scenario, ['frontend', 'backend'])) {
            $this->editor_id = Yii::$app->user->id;
        }

        return parent::beforeSave($insert);
    }

    /**
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        if (in_array($this->scenario, ['backend', 'frontend'])) {
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

                        if (in_array($specification_id, [6, 7, 8, 42]) && is_array($val)) {
                            foreach ($val as $k => $v) {
                                $model->{$k} = $v;
                            }
                        } else {
                            $model->val = $val;
                        }

                        $model->save();
                    }
                }
            }

            // Update Product Count In to Group
            Category::updateEnabledProductCount($this->category_ids);
            Factory::updateEnabledProductCount($this->factory_id);
        }

        if (in_array($this->scenario, ['frontend', 'backend'])) {
            ProductJson::add($this->id);
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
        return self::find()->joinWith(['lang']);
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
     * @param $model
     * @return string
     */
    public static function getStaticTitle($model)
    {
        return $model->lang->title ?? '{{-}}';
    }

 /**
     * @param $model
     * @return string
     */
    public function getTitle($model)
    {
        return $model['lang']['title'] ?? '{{-}}';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(ProductLang::class, ['rid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJson()
    {
        return $this->hasOne(ProductJson::class, ['rid' => 'id']);
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
            ->innerJoinWith('lang')
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
        return $this->hasOne(Factory::class, ['id' => 'factory_id'])->cache(7200);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEditor()
    {
        return $this->hasOne(User::class, ['id' => 'editor_id'])->cache(7200);
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
            ->viaTable(ProductRelSpecification::tableName() . ' ProductRelSpecification', ['catalog_item_id' => 'id']);
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

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getNoveltyRelCities()
    {
        return $this
            ->hasMany(City::class, ['id' => 'location_city_id'])
            ->viaTable(ProductNoveltyRelCity::tableName(), ['catalog_item_id' => 'id']);
    }
}
