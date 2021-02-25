<?php

namespace common\modules\catalog\models;

use DateTime;
use Yii;
use yii\helpers\{
    ArrayHelper
};
use yii\behaviors\AttributeBehavior;
use voskobovich\behaviors\ManyToManyBehavior;
use thread\app\base\models\ActiveRecord;
use common\helpers\Inflector;
use common\modules\location\models\{
    City, Country, Region
};
use common\modules\catalog\Catalog;
use common\modules\user\models\User;
use common\modules\payment\models\{
    Payment, PaymentRelItem
};
use common\modules\shop\models\{
    Order, OrderItem
};

/**
 * Class ItalianProduct
 *
 * @property integer $id
 * @property string $alias
 * @property string $alias_en
 * @property string $alias_it
 * @property string $alias_de
 * @property string $alias_he
 * @property integer $country_id
 * @property integer $region_id
 * @property integer $city_id
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
 * @property integer $bestseller
 * @property integer $is_sold
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $published
 * @property integer $published_date_from
 * @property integer $published_date_to
 * @property integer $deleted
 * @property integer $mark
 * @property integer $mark1
 * @property integer $mark2
 * @property integer $mark3
 * @property string $language_editing
 * @property integer $status
 * @property string $create_mode
 * @property string $isGrezzo
 * @property string $production_time_from
 * @property string $production_time_to
 *
 * @property ItalianProductLang $lang
 * @property ItalianProductRelCategory[] $category
 * @property ItalianProductRelSubTypes[] $subTypes
 * @property Payment $payment
 * @property Payment $paymentDelivery
 * @property ItalianProductRelSpecification[] $specificationValue
 * @property Factory $factory
 * @property User $user
 * @property Country $country
 * @property City $city
 * @property Region $region
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
            [['country_id', 'city_id'], 'required'],
            [
                [
                    'country_id',
                    'region_id',
                    'city_id',
                    'user_id',
                    'catalog_type_id',
                    'factory_id',
                    'created_at',
                    'updated_at',
                    'published_date_from',
                    'published_date_to',
                    'position'
                ],
                'integer'
            ],
            [
                ['price', 'volume', 'weight', 'price_new', 'price_without_technology'],
                'double'
            ],
            [
                ['price', 'volume', 'weight', 'price_new', 'price_without_technology'],
                'default',
                'value' => 0.00
            ],
            [
                [
                    'on_main',
                    'bestseller',
                    'is_sold',
                    'published',
                    'deleted',
                    'mark',
                    'mark1',
                    'mark2',
                    'mark3',
                    'isGrezzo'
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
                ['status'],
                'in',
                'range' => array_keys(static::statusRange())
            ],
            [
                ['create_mode'],
                'in',
                'range' => array_keys(static::createModeRange())
            ],
            [
                [
                    'phone',
                    'email',
                    'alias', 'alias_en', 'alias_it', 'alias_de', 'alias_he',
                    'factory_name',
                    'article',
                    'image_link',
                    'file_link',
                    'production_year',
                    'production_time_from',
                    'production_time_to'
                ],
                'string',
                'max' => 255
            ],
            [['email'], 'email'],
            [['gallery_image'], 'string', 'max' => 1024],
            [['alias', 'alias_en', 'alias_it', 'alias_de', 'alias_he'], 'unique'],
            [['factory_name',], 'default', 'value' => ''],
            [['catalog_type_id', 'factory_id', 'region_id', 'position'], 'default', 'value' => '0'],
            [['currency'], 'default', 'value' => 'EUR'],
            [['status'], 'default', 'value' => 'not_considered'],
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
    public function scenarios()
    {
        return [
            'published' => ['published', 'published_date_from', 'published_date_to'],
            'deleted' => ['deleted'],
            'on_main' => ['on_main'],
            'bestseller' => ['bestseller'],
            'is_sold' => ['is_sold'],
            'setImages' => ['image_link', 'gallery_image', 'file_link'],
            'mark' => ['mark'],
            'mark1' => ['mark1'],
            'mark2' => ['mark2'],
            'mark3' => ['mark3'],
            'setStatus' => ['status'],
            'create_mode' => ['create_mode'],
            'setAlias' => ['alias', 'alias_en', 'alias_it', 'alias_de', 'alias_he', 'mark3'],
            'backend' => [
                'country_id',
                'region_id',
                'city_id',
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
                'alias_en',
                'alias_it',
                'alias_de',
                'alias_he',
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
                'bestseller',
                'is_sold',
                'mark',
                'mark1',
                'mark2',
                'mark3',
                'language_editing',
                'create_mode',
                'status',
                'category_ids',
                'subtypes_ids',
                'colors_ids',
                'isGrezzo',
                'production_time_from',
                'production_time_to',
            ],
            'frontend' => [
                'country_id',
                'region_id',
                'city_id',
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
                'alias_en',
                'alias_it',
                'alias_de',
                'alias_he',
                'price',
                'price_new',
                'price_without_technology',
                'currency',
                'volume',
                'weight',
                'production_year',
                'position',
                'is_sold',
                'mark',
                'mark1',
                'mark2',
                'mark3',
                'language_editing',
                'create_mode',
                'category_ids',
                'subtypes_ids',
                'colors_ids',
                'isGrezzo',
                'production_time_from',
                'production_time_to',
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
            'region_id' => Yii::t('app', 'Region'),
            'city_id' => Yii::t('app', 'City'),
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
            'alias_en' => 'Alias for en',
            'alias_it' => 'Alias for it',
            'alias_de' => 'Alias for de',
            'alias_he' => 'Alias for he',
            'price' => Yii::t('app', 'Price'),
            'price_new' => Yii::t('app', 'New price'),
            'price_without_technology' => Yii::t('app', 'Price without technology'),
            'currency' => Yii::t('app', 'Currency'),
            'volume' => Yii::t('app', 'Volume'),
            'weight' => Yii::t('app', 'Weight'),
            'production_year' => Yii::t('app', 'Production year'),
            'on_main' => Yii::t('app', 'On main'),
            'bestseller' => Yii::t('app', 'Bestseller'),
            'is_sold' => Yii::t('app', 'Item sold'),
            'position' => Yii::t('app', 'Position'),
            'created_at' => Yii::t('app', 'Create time'),
            'updated_at' => Yii::t('app', 'Update time'),
            'published' => Yii::t('app', 'Published'),
            'published_date_from' => Yii::t('app', 'Published date from'),
            'published_date_to' => Yii::t('app', 'Published date to'),
            'deleted' => Yii::t('app', 'Deleted'),
            'mark',
            'mark1',
            'mark2',
            'mark3',
            'language_editing',
            'create_mode' => Yii::t('app', 'Placement option'),
            'status' => Yii::t('app', 'Status'),
            'category_ids' => Yii::t('app', 'Category'),
            'subtypes_ids' => Yii::t('app', 'Типы'),
            'colors_ids' => Yii::t('app', 'Colors'),
            'isGrezzo',
            'production_time_from' => Yii::t('app', 'от'),
            'production_time_to' => Yii::t('app', 'до'),
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

        if ($this->alias_he == '' && in_array($this->scenario, ['backend', 'setAlias', 'frontend'])) {
            $this->alias_he = (!empty($this->types) ? $this->types->alias_he : '')
                . (!empty($this->factory) ? ' ' . $this->factory->alias : '')
                . (($this->article) ? ' ' . $this->article : ' ' . uniqid());

            if ($this->id) {
                $this->alias_he = $this->id . ' ' . $this->alias_he;
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
        }

        if (in_array($this->scenario, ['published', 'backend'])) {
            if ($this->published == '1' && $this->published_date_from == 0 && $this->published_date_to == 0) {
                $this->published_date_from = time();
                $this->published_date_to = strtotime('+60 days');
            } elseif ($this->published == '0' && $this->published_date_from > 0) {
                $this->published_date_from = 0;
                $this->published_date_to = 0;
            }

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
                    if (in_array($specification_id, [9]) && $val) {
                        $model = new ItalianProductRelSpecification();

                        $model->setScenario('backend');
                        $model->item_id = $this->id;
                        $model->specification_id = $val;
                        $model->val = $specification_id;
                        $model->save();
                    } elseif (in_array($specification_id, [2, 60]) && is_array($val)) {
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
        } elseif ($this->scenario == 'backend') {
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
     * @param $key
     * @return array|mixed
     */
    public static function createModeRange($key = '')
    {
        $data = [
            'paid' => Yii::t('app', 'Paid {value}', ['value' => '50 EUR']),
            'free' => Yii::t('app', 'Free {value}', ['value' => '22%']),
        ];

        return $key ? $data[$key] : $data;
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
     * @param string $key
     * @return array|mixed
     */
    public static function statusRange($key = '')
    {
        $data = [
            'not_considered' => Yii::t('app', 'Not considered'),
            'not_approved' => Yii::t('app', 'Not approved'),
            'on_moderation' => Yii::t('app', 'On moderation'),
            'approved' => Yii::t('app', 'Approved')
        ];

        return $key ? $data[$key] : $data;
    }

    /**
     * @return mixed
     */
    public static function findBase()
    {
        return self::find()
            ->innerJoinWith(['lang'])
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
     * @throws \yii\base\InvalidConfigException
     */
    public function getSubTypes()
    {
        return $this
            ->hasMany(SubTypes::class, ['id' => 'subtype_id'])
            ->innerJoinWith('lang')
            ->viaTable(ItalianProductRelSubTypes::tableName(), ['item_id' => 'id']);
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
     * @throws \yii\base\InvalidConfigException
     */
    public function getPayment()
    {
        return $this
            ->hasOne(Payment::class, ['id' => 'payment_id'])
            ->viaTable(PaymentRelItem::tableName(), ['item_id' => 'id'])
            ->andWhere([Payment::tableName() . '.type' => 'italian_item'])
            ->orderBy(Payment::tableName() . '.id DESC');
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getPaymentDelivery()
    {
        return $this
            ->hasOne(Payment::class, ['id' => 'payment_id'])
            ->viaTable(PaymentRelItem::tableName(), ['item_id' => 'id'])
            ->andWhere([Payment::tableName() . '.type' => 'italian_item_delivery'])
            ->orderBy(Payment::tableName() . '.id DESC');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegion()
    {
        return $this->hasOne(Region::class, ['id' => 'region_id'])->cache(7200);
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
            if ($obj->parent_id == '9') {
                $style[] = $obj->id;
            }
            if ($obj->parent_id == '2') {
                $material[] = $obj->id;
            }
        }

        foreach ($this->specificationValue as $v) {
            if (in_array($v['specification_id'], [2, 60])) {
                $mas[$v['val']] = $v['specification_id'];
            } else {
                $mas[$v['specification_id']] = $v['val'];
            }

            if (in_array($v['specification_id'], $style)) {
                $mas['style'] = $v['specification_id'];
            }

            if (in_array($v['specification_id'], $material)) {
                $mas['material'] = $v['specification_id'];
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
            if (is_file($path . '/' . $image)) {
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

    /**
     * @param $ids
     * @param $user_id
     * @return array
     */
    public static function findByIDsUserId($ids, $user_id)
    {
        return self::findBase()->user_id($user_id)->andWhere(['IN', 'id', array_unique($ids)])->all();
    }

    /**
     * @return mixed
     */
    public function getCountViews()
    {
        return ItalianProductStats::findBase()
            ->andWhere(['product_id' => $this->id])
            ->count();
    }

    /**
     * @return mixed
     */
    public function getCountRequests()
    {
        return OrderItem::findBase()
            ->innerJoinWith(["order"], false)
            ->andWhere(['product_id' => $this->id, Order::tableName() . '.product_type' => 'sale-italy'])
            ->count();
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function getDiffPublishedDate()
    {
        $datetime1 = new DateTime('now');
        $datetime2 = (new DateTime())->setTimestamp($this->published_date_to);

        $interval = $datetime1->diff($datetime2);
        return $interval->format('%a');
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return isset($this->lang->title)
            ? $this->lang->title
            : "{{$this->default_title}}";
    }
}
