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
use common\modules\catalog\Catalog;
use common\modules\user\models\User;

/**
 * Class Sale
 *
 * @property integer $id
 * @property string $country_code
 * @property integer $user_id
 * @property integer $user_city_id
 * @property string $factory_name
 * @property integer $catalog_type_id
 * @property integer $factory_id
 * @property integer $gallery_id
 * @property integer $picpath
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
 * @property string $image_link
 * @property string $gallery_image
 *
 * @property SaleLang $lang
 * @property SaleRelCategory[] $category
 * @property Factory $factory
 * @property User $user
 * @property Types $types
 *
 * @package common\modules\catalog\models
 */
class Sale extends ActiveRecord
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
            [
                [
                    'user_id',
                    'user_city_id',
                    'catalog_type_id',
                    'factory_id',
                    'gallery_id',
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
                    'picpath',
                    'on_main',
                    'published',
                    'deleted',
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
            'setImages' => ['image_link', 'gallery_image', 'picpath'],
            'backend' => [
                'country_code',
                'user_id',
                'user_city_id',
                'factory_name',
                'catalog_type_id',
                'factory_id',
                'gallery_id',
                'image_link',
                'gallery_image',
                'picpath',
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
                'category_ids',
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
            'country_code' => 'Показывать для страны',
            'user_id' => 'User',
            'user_city_id' => 'User city id',
            'catalog_type_id' => 'Предмет',
            'factory_id' => Yii::t('app', 'Factory'),
            'factory_name' => 'Фабрика (если нету в списке)',
            'gallery_id' => 'Gallery',
            'image_link' => Yii::t('app', 'Image link'),
            'gallery_image' => Yii::t('app', 'Gallery image'),
            'picpath' => 'picpath',
            'alias' => Yii::t('app', 'Alias'),
            'article' => 'Артикул',
            'price' => 'Цена',
            'price_new' => 'Новая цена',
            'currency' => 'Валюта',
            'volume' => 'Объем',
            'on_main' => 'На главную',
            'position' => Yii::t('app', 'Position'),
            'created_at' => Yii::t('app', 'Create time'),
            'updated_at' => Yii::t('app', 'Update time'),
            'published' => Yii::t('app', 'Published'),
            'deleted' => Yii::t('app', 'Deleted'),
            'category_ids' => Yii::t('app', 'Category'),
        ];
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (Yii::$app->getUser()->getIdentity()->group->role == 'partner') {
            $this->user_id = Yii::$app->getUser()->id;
        }

        if ($this->alias == '') {
            $this->alias = time();
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
        return self::find()
            ->innerJoinWith(['lang'])
            ->orderBy('id DESC');
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
     */
    public function getCategory()
    {
        return $this
            ->hasMany(Category::class, ['id' => 'group_id'])
            ->viaTable(SaleRelCategory::tableName(), ['sale_item_id' => 'id']);
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
     */
    public function getSpecification()
    {
        return $this
            ->hasMany(Specification::class, ['id' => 'specification_id'])
            ->viaTable(SaleRelSpecification::tableName(), ['sale_catalog_item_id' => 'id']);
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
            if ($obj->parent_id === '9')
                $style[] = $obj->id;

            if ($obj->parent_id === '2')
                $material[] = $obj->id;
        }

        foreach ($this->specificationValue as $v) {
            $mas[$v['specification_id']] = $v['val'];

            if (in_array($v['specification_id'], $style))
                $mas['style'] = $v['spec_id'];

            if (in_array($v['specification_id'], $material))
                $mas['material'] = $v['spec_id'];
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

        $path = $module->getSaleUploadPath();
        $url = $module->getSaleUploadUrl();

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
}
