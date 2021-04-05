<?php

namespace common\modules\banner\models;

use Yii;
use yii\helpers\ArrayHelper;
use frontend\components\ImageResize;
use voskobovich\behaviors\ManyToManyBehavior;
use thread\app\base\models\ActiveRecord;
use common\modules\catalog\models\{
    Category, Factory
};
use common\modules\banner\BannerModule;
use common\modules\location\models\City;

/**
 * Class BannerItem
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $factory_id
 * @property string $type
 * @property string $side
 * @property string $background_code
 * @property string $image_link
 * @property integer $position
 * @property integer $created_at
 * @property integer $updated_at
 * @property boolean $published
 * @property boolean $deleted
 * @property boolean $show_filter
 *
 * @property Factory $factory
 * @property BannerItemRelCity $cities
 * @property BannerItemRelCatalogGroup $categories
 * @property BannerItemLang $lang
 *
 * @package common\modules\banner\models
 */
class BannerItem extends ActiveRecord
{
    /**
     * @return null|object|\yii\db\Connection
     * @throws \yii\base\InvalidConfigException
     */
    public static function getDb()
    {
        return BannerModule::getDb();
    }

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%banner_item}}';
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
                    'cities_ids' => 'cities',
                    'categories_ids' => 'categories',
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
            [['user_id', 'factory_id', 'position', 'create_time', 'update_time'], 'integer'],
            [['published', 'deleted', 'show_filter'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [['type'], 'in', 'range' => array_keys(static::typeKeyRange())],
            [['side'], 'in', 'range' => array_keys(static::sideKeyRange())],
            [['image_link'], 'string', 'max' => 255],
            [['background_code'], 'string', 'max' => 32],
            [['position'], 'default', 'value' => 0],
            [
                [
                    'cities_ids',
                    'categories_ids',
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
            'backend' => [
                'user_id',
                'factory_id',
                'type',
                'side',
                'background_code',
                'image_link',
                'position',
                'published',
                'deleted',
                'show_filter',
                'cities_ids',
                'categories_ids',
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
            'factory_id' => Yii::t('app', 'Factory'),
            'type',
            'side' => Yii::t('app', 'Side'),
            'background_code' => Yii::t('app', 'Background'),
            'image_link' => Yii::t('app', 'Image link'),
            'position' => Yii::t('app', 'Position'),
            'created_at' => Yii::t('app', 'Create time'),
            'updated_at' => Yii::t('app', 'Update time'),
            'published' => Yii::t('app', 'Published'),
            'deleted' => Yii::t('app', 'Deleted'),
            'show_filter' => 'Выводить форму поиска',
            'cities_ids' => Yii::t('app', 'Cities'),
            'categories_ids' => Yii::t('app', 'Categories'),
        ];
    }

    /**
     * @return array
     */
    public static function typeKeyRange()
    {
        return [
            'main' => 'main',
            'catalog' => 'catalog',
            'factory' => 'factory',
            'background' => 'background',
        ];
    }

    /**
     * @return array
     */
    public static function sideKeyRange()
    {
        return [
            'left' => Yii::t('app', 'Left side'),
            'right' => Yii::t('app', 'Right side'),
        ];
    }

    /**
     * @return mixed
     */
    public static function findBase()
    {
        return self::find()->joinWith(['lang'])->orderBy('position');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(BannerItemLang::class, ['rid' => 'id']);
    }

    /**
     * @return null|string
     */
    public function getImageLink()
    {
        /** @var BannerModule $module */
        $module = Yii::$app->getModule('banner');

        $path = $module->getBannerUploadPath();
        $url = $module->getBannerUploadUrl();

        $image = null;

        if (!empty($this->image_link) && is_file($path . '/' . $this->image_link)) {
            $image = $url . '/' . $this->image_link;
        } else {
            $image = 'https://www.myarredo.ru/uploads/banner/' . $this->image_link;
        }

        return $image;
    }

    /**
     * @param int $width
     * @param int $height
     * @return string
     */
    public function getImageThumb($width = 460, $height = 200)
    {
        /** @var BannerModule $module */
        $module = Yii::$app->getModule('banner');

        $path = $module->getBannerUploadPath();
        $url = $module->getBannerUploadUrl();

        $image = null;

        if (!empty($this->image_link) && is_file($path . '/' . $this->image_link)) {
            // resize
            $ImageResize = new ImageResize();
            $image = 'https://img.' . DOMAIN_NAME . '.' . DOMAIN_TYPE . $ImageResize->getThumb($path . '/' . $this->image_link, $width, $height);
        } else {
            $image = 'https://www.myarredo.ru/uploads/banner/' . $this->image_link;
        }

        return $image;
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
    public function getCities()
    {
        return $this
            ->hasMany(City::class, ['id' => 'city_id'])
            ->viaTable(BannerItemRelCity::tableName(), ['item_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getCategories()
    {
        return $this
            ->hasMany(Category::class, ['id' => 'category_id'])
            ->viaTable(BannerItemRelCatalogGroup::tableName(), ['item_id' => 'id']);
    }
}
