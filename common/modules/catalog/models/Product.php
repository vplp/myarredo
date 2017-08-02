<?php

namespace common\modules\catalog\models;

use Yii;
use yii\helpers\{
    ArrayHelper
};
use thread\app\base\models\ActiveRecord;
use common\modules\catalog\Catalog;

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
 *
 * @property ProductLang $lang
 * @property ProductRelCategory[] $category
 * @property Factory $factory
 *
 * @package common\modules\catalog\models
 */
class Product extends ActiveRecord
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

        ]);
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['alias', 'article', 'factory_id', 'catalog_type_id'], 'required'],
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
            [['country_code', 'user', 'alias', 'alias_old', 'default_title'], 'string', 'max' => 255],
            [['article'], 'string', 'max' => 100],
            [['alias'], 'unique'],
            [['collections_id', 'position'], 'default', 'value' => '0'],
            [['country_code'], 'default', 'value' => '//']
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
                'factory_id',
                'collections_id',
                'gallery_id',
                'created_at',
                'updated_at',
                'position',
                'price',
                'volume',
                'factory_price',
                'price_from',
                'retail_price',
                'picpath',
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
                'article'
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
            'novelty' => 'Новинка',
            'moderation' => 'На проверке',
            'bestseller' => 'Бестселлер',
            'onmain' => 'На главную',
            'position' => Yii::t('app', 'Position'),
            'created_at' => Yii::t('app', 'Create time'),
            'updated_at' => Yii::t('app', 'Update time'),
            'published' => Yii::t('app', 'Published'),
            'deleted' => Yii::t('app', 'Deleted'),
            'category' => Yii::t('app', 'Category'),
        ];
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if ($this->id) {
            $alias = explode($this->id . '_', $this->alias);
            if (empty($alias) || count($alias) == 1) {
                $this->alias = $this->id . '_' . $this->alias;
            }
        }

        $this->user_id = Yii::$app->getUser()->id;
        $userIdentity = Yii::$app->getUser()->getIdentity();
        $this->user = $userIdentity->profile->first_name . ' ' . $userIdentity->profile->last_name;

        return parent::beforeSave($insert);
    }

    /**
     * @return mixed
     */
    public static function findBase()
    {
        return self::find()
            ->joinWith(['lang'])
            ->andWhere(['is_composition' => '0'])
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
    public function getProductImage()
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
    public function getFactory()
    {
        return $this->hasOne(Factory::class, ['id' => 'factory_id']);
    }

    public function getSpecificationRelProduct()
    {
        return null;
    }
}
