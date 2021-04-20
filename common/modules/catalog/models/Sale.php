<?php

namespace common\modules\catalog\models;

use Yii;
use yii\helpers\{
    ArrayHelper
};
use common\helpers\Inflector;
use yii\behaviors\AttributeBehavior;
use voskobovich\behaviors\ManyToManyBehavior;
use thread\app\base\models\ActiveRecord;
use common\modules\location\models\{
    City, Country
};
use common\modules\catalog\Catalog;
use common\modules\user\models\User;

/**
 * Class Sale
 *
 * @property integer $id
 * @property integer $country_id
 * @property integer $city_id
 * @property string $country_code
 * @property integer $user_id
 * @property integer $user_city_id
 * @property string $factory_name
 * @property integer $catalog_type_id
 * @property integer $factory_id
 * @property string $alias
 * @property string $article
 * @property double $price
 * @property double $price_new
 * @property string $currency
 * @property string $volume
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $published
 * @property integer $deleted
 * @property integer $position
 * @property integer $on_main
 * @property integer $is_sold
 * @property string $image_link
 * @property string $gallery_image
 * @property integer $mark
 * @property integer $mark1
 * @property integer $mark2
 * @property integer $mark3
 * @property string $language_editing
 *
 * @property SaleLang $lang
 * @property SaleRelCategory[] $category
 * @property SaleRelSubTypes[] $subTypes
 * @property Factory $factory
 * @property User $user
 * @property Country $country
 * @property City $city
 * @property Types $types
 *
 * @package common\modules\catalog\models
 */
class Sale extends ActiveRecord
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
        return '{{%catalog_sale_item}}';
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
                    'colors_ids' => 'colors',
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
            [['country_id', 'city_id'], 'required'],
            [['category_ids', 'catalog_type_id', 'colors_ids'], 'required', 'on' => ['frontend']],
            [
                [
                    'country_id',
                    'city_id',
                    'user_id',
                    'user_city_id',
                    'catalog_type_id',
                    'factory_id',
                    'created_at',
                    'updated_at',
                    'position'
                ],
                'integer'
            ],
            [['price', 'volume', 'price_new'], 'double'],
            [['price', 'volume', 'price_new'], 'default', 'value' => 0.00],
            [
                [
                    'on_main',
                    'is_sold',
                    'published',
                    'deleted',
                    'mark',
                    'mark1',
                    'mark2',
                    'mark3',
                ],
                'in',
                'range' => array_keys(static::statusKeyRange())
            ],
            [['currency'], 'in', 'range' => array_keys(static::currencyRange())],
            [['country_code', 'alias', 'factory_name', 'image_link'], 'string', 'max' => 255],
            [['gallery_image'], 'string', 'max' => 1024],
            [['article'], 'string', 'max' => 100],
            [['alias'], 'unique'],
            [['position'], 'default', 'value' => '0'],
            [['currency'], 'default', 'value' => 'EUR'],
            [['country_code'], 'default', 'value' => '//'],
            [['article'], 'default', 'value' => ''],
            [
                [
                    'category_ids',
                    'subtypes_ids',
                    'colors_ids',
                ],
                'each',
                'rule' => ['integer']
            ],
            [['language_editing'], 'string', 'max' => 5],
            [['language_editing'], 'default', 'value' => ''],
        ];
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
     * @return array
     */
    public function scenarios()
    {
        return [
            'published' => ['published'],
            'deleted' => ['deleted'],
            'on_main' => ['on_main'],
            'is_sold' => ['is_sold'],
            'setImages' => ['image_link', 'gallery_image'],
            'mark' => ['mark'],
            'mark1' => ['mark1'],
            'mark2' => ['mark2'],
            'mark3' => ['mark3'],
            'backend' => [
                'country_id',
                'city_id',
                'country_code',
                'user_id',
                'user_city_id',
                'factory_name',
                'catalog_type_id',
                'factory_id',
                'image_link',
                'gallery_image',
                'alias',
                'article',
                'price',
                'price_new',
                'currency',
                'volume',
                'published',
                'deleted',
                'position',
                'on_main',
                'is_sold',
                'category_ids',
                'subtypes_ids',
                'colors_ids',
                'mark',
                'mark1',
                'mark2',
                'mark3',
                'language_editing'
            ],
            'frontend' => [
                'country_id',
                'city_id',
                'country_code',
                'user_id',
                'user_city_id',
                'factory_name',
                'catalog_type_id',
                'factory_id',
                'image_link',
                'gallery_image',
                'alias',
                'article',
                'price',
                'price_new',
                'currency',
                'volume',
                'published',
                'deleted',
                'position',
                'on_main',
                'is_sold',
                'category_ids',
                'subtypes_ids',
                'colors_ids',
                'mark',
                'mark1',
                'mark2',
                'mark3',
                'language_editing'
            ]
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'country_id' => Yii::t('app', 'Country'),
            'city_id' => Yii::t('app', 'City'),
            'country_code' => 'Показывать для страны',
            'user_id' => Yii::t('app', 'User'),
            'user_city_id' => Yii::t('app', 'City'),
            'catalog_type_id' => Yii::t('app', 'Catalog type'),
            'factory_id' => Yii::t('app', 'Factory'),
            'factory_name' => Yii::t('app', 'Фабрика (если нет в списке)'),
            'image_link' => Yii::t('app', 'Image link'),
            'gallery_image' => Yii::t('app', 'Gallery image'),
            'alias' => Yii::t('app', 'Alias'),
            'article' => Yii::t('app', 'Артикул'),
            'price' => Yii::t('app', 'Price'),
            'price_new' => Yii::t('app', 'New price'),
            'currency' => Yii::t('app', 'Currency'),
            'volume' => Yii::t('app', 'Volume'),
            'on_main' => Yii::t('app', 'On main'),
            'is_sold' => Yii::t('app', 'Item sold'),
            'position' => Yii::t('app', 'Position'),
            'created_at' => Yii::t('app', 'Create time'),
            'updated_at' => Yii::t('app', 'Update time'),
            'published' => Yii::t('app', 'Published'),
            'deleted' => Yii::t('app', 'Deleted'),
            'category_ids' => Yii::t('app', 'Category'),
            'subtypes_ids' => Yii::t('app', 'Типы'),
            'colors_ids' => Yii::t('app', 'Colors'),
            'mark',
            'mark1',
            'mark2',
            'mark3',
            'language_editing'
        ];
    }

    /**
     * @param bool $insert
     * @return bool
     * @throws \Throwable
     */
    public function beforeSave($insert)
    {
        if ($this->alias == '' && in_array($this->scenario, ['backend', 'frontend'])) {
            $this->alias = (!empty($this->types) ? $this->types->alias : '') .
                (!empty($this->factory) ? ' ' . $this->factory->alias : '') .
                (($this->article) ? ' ' . $this->article : ' ' . uniqid());

            if ($this->id) {
                $this->alias = $this->id . ' ' . $this->alias;
            }
        }

        if ($this->factory_name) {
            $this->factory_name = trim($this->factory_name);
        }

        if ($this->article) {
            $this->article = trim($this->article);
        }

        if (in_array($this->scenario, ['frontend', 'backend'])) {
            $this->mark = '0';
            $this->mark1 = '0';
            $this->language_editing = Yii::$app->language;

            if ($this->factory_name) {
                $this->factory_id = Factory::createByName($this->factory_name);
                $this->factory_name = '';
            }
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
        if ($this->scenario == 'frontend') {
            // delete relation SaleRelSpecification
            SaleRelSpecification::deleteAll(['sale_catalog_item_id' => $this->id]);

            // save relation SaleRelSpecification
            if (Yii::$app->request->getBodyParam('SpecificationValue')) {
                foreach (Yii::$app->request->getBodyParam('SpecificationValue') as $specification_id => $val) {
                    if (in_array($specification_id, [2, 9]) && $val) {
                        $model = new SaleRelSpecification();

                        $model->setScenario('backend');
                        $model->sale_catalog_item_id = $this->id;
                        $model->specification_id = $val;
                        $model->val = $specification_id;
                        $model->save();
                    } elseif ($specification_id && $val) {
                        $model = new SaleRelSpecification();

                        $model->setScenario('backend');
                        $model->sale_catalog_item_id = $this->id;
                        $model->specification_id = $specification_id;
                        $model->val = $val;

                        $model->save();
                    }
                }
            }
        } else if ($this->scenario == 'backend') {
            // delete relation SaleRelSpecification
            SaleRelSpecification::deleteAll(['sale_catalog_item_id' => $this->id]);

            // save relation SaleRelSpecification
            if (Yii::$app->request->getBodyParam('SpecificationValue')) {
                foreach (Yii::$app->request->getBodyParam('SpecificationValue') as $specification_id => $val) {
                    if ($val) {
                        $model = new SaleRelSpecification();
                        $model->setScenario('backend');
                        $model->sale_catalog_item_id = $this->id;
                        $model->specification_id = $specification_id;
                        $model->val = $val;
                        $model->save();
                    }
                }
            }
        }

        parent::afterSave($insert, $changedAttributes);
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
     * @return \yii\db\ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(SaleLang::class, ['rid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getCategory()
    {
        return $this
            ->hasMany(Category::class, ['id' => 'group_id'])
            ->viaTable(SaleRelCategory::tableName(), ['sale_item_id' => 'id']);
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
            ->viaTable(SaleRelSubTypes::tableName(), ['item_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::class, ['id' => 'country_id'])->cache(7200);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::class, ['id' => 'city_id'])->cache(7200);
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
    public function getTypes()
    {
        return $this->hasOne(Types::class, ['id' => 'catalog_type_id'])->cache(7200);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id'])->cache(7200);
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getColors()
    {
        return $this
            ->hasMany(Colors::class, ['id' => 'color_id'])
            ->viaTable(ColorsRelSaleProduct::tableName(), ['item_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getSpecification()
    {
        return $this
            ->hasMany(Specification::class, ['id' => 'specification_id'])
            ->viaTable(SaleRelSpecification::tableName() . ' SaleRelSpecification', ['sale_catalog_item_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSpecificationValue()
    {
        return $this
            ->hasMany(SaleRelSpecification::class, ['sale_catalog_item_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSpecificationValueBySpecification()
    {
        $specification = Specification::findBase()->all();

        $style = $material = [];
        foreach ($specification as $obj) {
            if ($obj->parent_id === '9') {
                $style[] = $obj->id;
            }
            if ($obj->parent_id === '2') {
                $material[] = $obj->id;
            }
        }

        foreach ($this->specificationValue as $v) {
            $mas[$v['specification_id']] = $v['val'];

            if (in_array($v['specification_id'], $style)) {
                $mas['style'] = $v['specification_id'];
            }
            if (in_array($v['specification_id'], $material)) {
                $mas['material'] = $v['specification_id'];
            }
        }

        return (!empty($mas)) ? $mas : array();

        return $this->specificationValue;
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

        $this->gallery_image = implode(',', $images);

        return $imagesSources;
    }

    /**
     * @return mixed
     */
    public function getCountViews()
    {
        return SaleStats::findBase()
            ->andWhere(['product_id' => $this->id])
            ->count();
    }

    /**
     * @return mixed
     */
    public function getCountRequestPhone()
    {
        return SalePhoneRequest::findBase()
            ->andWhere(['sale_item_id' => $this->id])
            ->count();
    }
}
