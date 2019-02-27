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
//
use common\helpers\Inflector;
use common\modules\location\models\{
    City, Country
};
use common\modules\catalog\Catalog;
use common\modules\user\models\User;

/**
 * Class ItalianProduct
 *
 * @property integer $id
 * @property string $alias
 * @property integer $country_id
 * @property integer $city_id
 * @property string $region
 * @property string $phone
 * @property string $email
 * @property integer $user_id
 * @property integer $catalog_type_id
 * @property integer $factory_id
 * @property string $image_link
 * @property string $factory_name
 * @property string $article
 * @property string $gallery_image
 * @property string $file_link
 * @property double $price
 * @property double $price_new
 * @property double $price_without_technology
 * @property string $currency
 * @property float $volume
 * @property float $weight
 * @property float $production_year
 * @property integer $position
 * @property integer $on_main
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $published
 * @property integer $deleted
 *
 * @property ItalianProductLang $lang
 * @property ItalianProductRelCategory[] $category
 * @property ItalianProductRelSpecification[] $specificationValue
 * @property Factory $factory
 * @property User $user
 * @property Country $country
 * @property City $city
 * @property Types $types
 *
 * @package common\modules\catalog\models
 */
class ItalianProduct extends ActiveRecord
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
        return '{{%catalog_italian_item}}';
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
            [
                [
                    'country_id',
                    'city_id',
                    'user_id',
                    'catalog_type_id',
                    'factory_id',
                    'created_at',
                    'updated_at',
                    'position'
                ],
                'integer'
            ],
            [['price', 'volume', 'weight', 'price_new', 'price_without_technology'], 'double'],
            [['price', 'volume', 'weight', 'price_new', 'price_without_technology'], 'default', 'value' => 0.00],
            [
                [
                    'on_main',
                    'published',
                    'deleted',
                ],
                'in',
                'range' => array_keys(static::statusKeyRange())
            ],
            [
                ['currency'],
                'in',
                'range' => array_keys(static::currencyRange())
            ],
            [
                [
                    'region',
                    'phone',
                    'email',
                    'alias',
                    'factory_name',
                    'article',
                    'image_link',
                    'file_link',
                    'production_year',
                ],
                'string',
                'max' => 255
            ],
            [['email'], 'email'],
            [['gallery_image'], 'string', 'max' => 1024],
            [['alias'], 'unique'],
            [['factory_name',], 'default', 'value' => ''],
            [['catalog_type_id', 'factory_id', 'position'], 'default', 'value' => '0'],
            [['currency'], 'default', 'value' => 'EUR'],
            [
                [
                    'category_ids',
                    'colors_ids',
                ],
                'each',
                'rule' => ['integer']
            ],
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
            'setImages' => ['image_link', 'gallery_image'],
            'backend' => [
                'country_id',
                'city_id',
                'region',
                'phone',
                'email',
                'user_id',
                'catalog_type_id',
                'factory_id',
                'factory_name',
                'article',
                'image_link',
                'gallery_image',
                'file_link',
                'alias',
                'price',
                'price_new',
                'price_without_technology',
                'currency',
                'volume',
                'weight',
                'production_year',
                'published',
                'deleted',
                'position',
                'on_main',
                'category_ids',
                'colors_ids',
            ],
            'frontend' => [
                'country_id',
                'city_id',
                'region',
                'phone',
                'email',
                'user_id',
                'catalog_type_id',
                'factory_id',
                'factory_name',
                'article',
                'image_link',
                'gallery_image',
                'file_link',
                'alias',
                'price',
                'price_new',
                'price_without_technology',
                'currency',
                'volume',
                'weight',
                'production_year',
                'published',
                'deleted',
                'position',
                'on_main',
                'category_ids',
                'colors_ids',
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
            'region' => Yii::t('app', 'Region'),
            'phone' => Yii::t('app', 'Phone'),
            'email' => Yii::t('app', 'Email'),
            'user_id' => Yii::t('app', 'User'),
            'catalog_type_id' => Yii::t('app', 'Catalog type'),
            'factory_id' => Yii::t('app', 'Factory'),
            'factory_name' => Yii::t('app', 'Фабрика (если нет в списке)'),
            'article' => Yii::t('app', 'Артикул'),
            'image_link' => Yii::t('app', 'Image link'),
            'gallery_image' => Yii::t('app', 'Gallery image'),
            'file_link' => Yii::t('app', 'Project drawing'),
            'alias' => Yii::t('app', 'Alias'),
            'price' => Yii::t('app', 'Price'),
            'price_new' => Yii::t('app', 'New price'),
            'price_without_technology' => Yii::t('app', 'Price without technology'),
            'currency' => Yii::t('app', 'Currency'),
            'volume' => Yii::t('app', 'Volume'),
            'weight' => Yii::t('app', 'Weight'),
            'production_year' => Yii::t('app', 'Production year'),
            'on_main' => Yii::t('app', 'On main'),
            'position' => Yii::t('app', 'Position'),
            'created_at' => Yii::t('app', 'Create time'),
            'updated_at' => Yii::t('app', 'Update time'),
            'published' => Yii::t('app', 'Published'),
            'deleted' => Yii::t('app', 'Deleted'),
            'category_ids' => Yii::t('app', 'Category'),
            'colors_ids' => Yii::t('app', 'Colors'),
        ];
    }

    /**
     * @param bool $insert
     * @return bool
     * @throws \Throwable
     */
    public function beforeSave($insert)
    {
        if ($this->alias == '') {
            $this->alias = time();
        }

        return parent::beforeSave($insert);
    }

    public function beforeValidate()
    {
        $this->country_id = 4;
        $this->city_id = 159;

        return parent::beforeValidate();
    }

    /**
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        if ($this->scenario == 'frontend') {
            // delete relation ItalianProductRelSpecification
            ItalianProductRelSpecification::deleteAll(['item_id' => $this->id]);

            // save relation ItalianProductRelSpecification
            if (Yii::$app->request->getBodyParam('SpecificationValue')) {
                foreach (Yii::$app->request->getBodyParam('SpecificationValue') as $specification_id => $val) {
                    if (in_array($specification_id, [2, 9]) && $val) {
                        $model = new ItalianProductRelSpecification();

                        $model->setScenario('backend');
                        $model->item_id = $this->id;
                        $model->specification_id = $val;
                        $model->val = $specification_id;
                        $model->save();
                    } elseif (in_array($specification_id, [60]) && is_array($val)) {
                        foreach ($val as $v) {
                            $model = new ItalianProductRelSpecification();

                            $model->setScenario('backend');
                            $model->item_id = $this->id;
                            $model->specification_id = $specification_id;
                            $model->val = $v;

                            $model->save();
                        }
                    } else {
                        $model = new ItalianProductRelSpecification();

                        $model->setScenario('backend');
                        $model->item_id = $this->id;
                        $model->specification_id = $specification_id;
                        $model->val = $val;

                        $model->save();
                    }
                }
            }
        } else if ($this->scenario == 'backend') {
            // delete relation ItalianProductRelSpecification
            ItalianProductRelSpecification::deleteAll(['item_id' => $this->id]);

            // save relation ItalianProductRelSpecification
            if (Yii::$app->request->getBodyParam('SpecificationValue')) {
                foreach (Yii::$app->request->getBodyParam('SpecificationValue') as $specification_id => $val) {
                    if ($val) {
                        $model = new ItalianProductRelSpecification();
                        $model->setScenario('backend');
                        $model->item_id = $this->id;
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
        return self::find()
            ->joinWith(['lang'])
            ->orderBy(self::tableName() . '.updated_at DESC');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(ItalianProductLang::class, ['rid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getCategory()
    {
        return $this
            ->hasMany(Category::class, ['id' => 'group_id'])
            ->viaTable(ItalianProductRelCategory::tableName(), ['item_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::class, ['id' => 'country_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::class, ['id' => 'city_id']);
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
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getColors()
    {
        return $this
            ->hasMany(Colors::class, ['id' => 'color_id'])
            ->viaTable(ColorsRelItalianProduct::tableName(), ['item_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getSpecification()
    {
        return $this
            ->hasMany(Specification::class, ['id' => 'specification_id'])
            ->viaTable(ItalianProductRelSpecification::tableName(), ['item_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSpecificationValue()
    {
        return $this
            ->hasMany(ItalianProductRelSpecification::class, ['item_id' => 'id']);
    }

    /**
     * @return array|ItalianProductRelSpecification[]
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
            if ($v['specification_id'] == 60) {
                $mas[$v['val']] = $v['specification_id'];
            } else {
                $mas[$v['specification_id']] = $v['val'];
            }

            if (in_array($v['specification_id'], $style)) {
                $mas['style'] = $v['spec_id'];
            }
            if (in_array($v['specification_id'], $material)) {
                $mas['material'] = $v['spec_id'];
            }
        }

        return (!empty($mas)) ? $mas : array();
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

        foreach ($images as $image) {
            if (file_exists($path . '/' . $image)) {
                $imagesSources[] = $url . '/' . $image;
            }
        }

        return $imagesSources;
    }

    /**
     * @return null|string
     */
    public function getFileLink()
    {
        /** @var Catalog $module */
        $module = Yii::$app->getModule('catalog');

        $path = $module->getItalianProductFileUploadPath();
        $url = $module->getItalianProductFileUploadUrl();

        $image = null;

        if (!empty($this->file_link) && is_file($path . '/' . $this->file_link)) {
            $image = $url . '/' . $this->file_link;
        }

        return $image;
    }

    /**
     * @return null|string
     */
    public function getFileSize()
    {
        /** @var Catalog $module */
        $module = Yii::$app->getModule('catalog');

        $path = $module->getItalianProductFileUploadPath();

        $file_size = 0;

        if (!empty($this->file_link) && is_file($path . '/' . $this->file_link)) {
            $file_size = filesize($path . '/' . $this->file_link);
        }

        return $file_size;
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
}
