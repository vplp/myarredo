<?php

namespace common\modules\catalog\models;

use Yii;
use yii\helpers\{
    ArrayHelper
};
//
use voskobovich\behaviors\ManyToManyBehavior;
//
use thread\app\base\models\ActiveRecord;
//
use common\modules\catalog\Catalog;

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
 *
 * @property SaleLang $lang
 * @property SaleRelCategory[] $category
 * @property Factory $factory
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
        ]);
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['alias'], 'required'],
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
            [['country_code', 'alias', 'factory_name'], 'string', 'max' => 255],
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
            'backend' => [
                'country_code',
                'user_id',
                'user_city_id',
                'factory_name',
                'catalog_type_id',
                'factory_id',
                'gallery_id',
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
        $this->user_id = Yii::$app->getUser()->id;

        return parent::beforeSave($insert);
    }

    /**
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
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
     * @return null|string
     */
    public function getImageLink()
    {
        $image = null;

        return $image;
    }
}
