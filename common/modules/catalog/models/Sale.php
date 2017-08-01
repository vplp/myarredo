<?php

namespace common\modules\catalog\models;

use Yii;
use yii\behaviors\AttributeBehavior;
use yii\helpers\{
    ArrayHelper, Inflector
};
use thread\app\base\models\ActiveRecord;
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
            [['alias', 'article'], 'required'],
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
            [['country_code'], 'default', 'value' => '//']
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
                'on_main'
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
            'factory_id' => 'Фабрика',
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
     * @return mixed
     */
    public static function findBase()
    {
        return self::find()
            ->joinWith(['lang'])
            ->orderBy('id DESC');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(SaleLang::class, ['rid' => 'id']);
    }
}
