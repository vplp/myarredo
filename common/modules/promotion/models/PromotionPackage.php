<?php

namespace common\modules\promotion\models;

use Yii;
use yii\helpers\ArrayHelper;
//
use common\modules\promotion\PromotionModule;
//
use thread\app\base\models\ActiveRecord;

/**
 * Class PromotionPackage
 *
 * @property integer $id
 * @property integer $image_link
 * @property integer $price
 * @property integer $currency
 * @property integer $position
 * @property integer $created_at
 * @property integer $updated_at
 * @property boolean $published
 * @property boolean $deleted
 *
 * @property PromotionPackageLang $lang
 *
 * @package common\modules\promotion\models
 */
class PromotionPackage extends ActiveRecord
{
    /**
     * @return object|string|\yii\db\Connection|null
     * @throws \yii\base\InvalidConfigException
     */
    public static function getDb()
    {
        return PromotionModule::getDb();
    }

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%promotion_package}}';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), []);
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['price'], 'double'],
            [['price'], 'default', 'value' => 0.00],
            [['currency'], 'in', 'range' => array_keys(static::currencyRange())],
            [['currency'], 'default', 'value' => 'EUR'],
            [['image_link'], 'string', 'max' => 255],
            [['position', 'created_at', 'updated_at'], 'integer'],
            [['position'], 'default', 'value' => 0],
            [['published', 'deleted'], 'in', 'range' => array_keys(static::statusKeyRange())],
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
                'price',
                'currency',
                'image_link',
                'position',
                'published',
                'deleted',
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
            'image_link' => Yii::t('app', 'Image link'),
            'price' => Yii::t('app', 'Price'),
            'currency' => Yii::t('app', 'Currency'),
            'position' => Yii::t('app', 'Position'),
            'created_at' => Yii::t('app', 'Create time'),
            'updated_at' => Yii::t('app', 'Update time'),
            'published' => Yii::t('app', 'Published'),
            'deleted' => Yii::t('app', 'Deleted'),
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
     * @return mixed
     */
    public static function findBase()
    {
        return self::find()->innerJoinWith(["lang"])->orderBy(['position' => SORT_DESC]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(PromotionPackageLang::class, ['rid' => 'id']);
    }

    /**
     * Title
     *
     * @return string
     */
    public function getTitle()
    {
        $title = $this->lang->title ?? '{{-}}';

        return $title;
    }

    /**
     * @return null|string
     */
    public function getImageLink()
    {
        /** @var PromotionModule $module */
        $module = Yii::$app->getModule('promotion');

        $path = $module->getUploadPath();
        $url = $module->getUploadUrl();

        $image = null;

        if (!empty($this->image_link) && is_file($path . '/' . $this->image_link)) {
            $image = $url . '/' . $this->image_link;
        }

        return $image;
    }
}
