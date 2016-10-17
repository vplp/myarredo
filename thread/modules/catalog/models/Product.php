<?php

namespace thread\modules\catalog\models;

use Yii;
//
use yii\behaviors\AttributeBehavior;
//
use yii\helpers\{
    ArrayHelper, Inflector
};
//
use thread\app\base\models\ActiveRecord;
//
use thread\modules\catalog\Catalog as CatalogModule;

/**
 * Class Product
 *
 * @property integer $id
 * @property string $alias
 * @property string $image_link
 * @property string $gallery_image
 * @property integer $position
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $published
 * @property integer $deleted
 *
 * @property ProductLang $lang
 *
 * @package thread\modules\catalog\models
 * @author Andrii Bondarchuk
 * @copyright (c) 2016, VipDesign
 */
class Product extends ActiveRecord
{
    /**
     * @return string
     */
    public static function getDb()
    {
        return CatalogModule::getDb();
    }

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%catalog_product}}';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'alias',
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'alias',
                ],
                'value' => function ($event) {
                    return Inflector::slug($this->alias);
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
            [['alias'], 'required'],
            [['position', 'created_at', 'updated_at'], 'integer'],
            [['published', 'deleted'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [['alias', 'image_link'], 'string', 'max' => 255],
            [['gallery_image'], 'string', 'max' => 1024],
            [['alias'], 'unique']
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
            'backend' => ['alias', 'image_link', 'gallery_image', 'position', 'published', 'deleted'],
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
            'image_link' => Yii::t('app', 'Image link'),
            'gallery_image' => Yii::t('app', 'Gallery image'),
            'position' => Yii::t('app', 'Position'),
            'created_at' => Yii::t('app', 'Create time'),
            'updated_at' => Yii::t('app', 'Update time'),
            'published' => Yii::t('app', 'Published'),
            'deleted' => Yii::t('app', 'Deleted'),
        ];
    }

    /**
     * @return mixed
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
        $module = Yii::$app->getModule('catalog');
        $path = $module->getBaseProductUploadPath();
        $url = $module->getBaseProductUploadUrl();
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
        $module = Yii::$app->getModule('catalog');
        $path = $module->getBaseProductUploadPath();
        $url = $module->getBaseProductUploadUrl();
        $images = [];

        if (!empty($this->gallery_image)) {
            $this->gallery_image = $this->gallery_image[0] == ',' ? substr($this->gallery_image, 1) : $this->gallery_image;
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