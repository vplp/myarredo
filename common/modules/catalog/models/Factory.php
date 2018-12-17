<?php

namespace common\modules\catalog\models;

use Yii;
use yii\helpers\{
    ArrayHelper
};
use yii\behaviors\AttributeBehavior;
//
use thread\app\base\models\ActiveRecord;
//
use common\modules\catalog\Catalog;
use common\helpers\Inflector;

/**
 * Class Factory
 *
 * @property integer $id
 * @property string $country_code
 * @property string $alias
 * @property string $title
 * @property string $first_letter
 * @property string $url
 * @property string $email
 * @property boolean $popular
 * @property boolean $popular_by
 * @property boolean $popular_ua
 * @property integer $created_at
 * @property integer $updated_at
 * @property boolean $published
 * @property boolean $deleted
 * @property integer $novelty
 * @property string $novelty_url
 * @property string $image_link
 * @property integer $position
 * @property integer $partner_id
 * @property integer $alternative
 * @property integer $new_price
 * @property boolean $show_for_ru
 * @property boolean $show_for_by
 * @property boolean $show_for_ua
 *
 * @property FactoryLang $lang
 * @property Collection $collection
 * @property FactoryFile $files
 * @property CatalogsFiles[] $catalogsFiles
 * @property PricesFiles[] $pricesFiles
 *
 * @package common\modules\catalog\models
 */
class Factory extends ActiveRecord
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
        return '{{%catalog_factory}}';
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
            [['alias', 'title'], 'required'],
            [['created_at', 'updated_at', 'position', 'partner_id'], 'integer'],
            [
                [
                    'published',
                    'deleted',
                    'position',
                    'popular_ua',
                    'popular_by',
                    'novelty',
                    'alternative',
                    'new_price',
                    'show_for_ru',
                    'show_for_by',
                    'show_for_ua'
                ],
                'in',
                'range' => array_keys(static::statusKeyRange())
            ],
            [
                ['alias', 'title', 'country_code', 'url', 'email', 'novelty_url', 'image_link'],
                'string',
                'max' => 255
            ],
            [['first_letter'], 'string', 'max' => 2],
            [['alias'], 'unique'],
            [['position', 'partner_id'], 'default', 'value' => '0'],
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
            'position' => ['position'],
            'popular' => ['popular'],
            'popular_by' => ['popular_by'],
            'popular_ua' => ['popular_ua'],
            'backend' => [
                'title',
                'alias',
                'country_code',
                'url',
                'email',
                'novelty_url',
                'image_link',
                'first_letter',
                'published',
                'deleted',
                'position',
                'popular_ua',
                'popular_by',
                'novelty',
                'alternative',
                'position',
                'partner_id',
                'new_price',
                'show_for_ru',
                'show_for_by',
                'show_for_ua'
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
            'title' => Yii::t('app', 'Title'),
            'country_code' => 'Показывать для страны',
            'url' => 'url',
            'email' => 'E-Mail',
            'novelty_url' => 'Новинки url',
            'image_link' => 'Изображение',
            'novelty' => 'Новинки',
            'popular' => 'Популярный Ru',
            'popular_by' => 'Популярный By',
            'popular_ua' => 'Популярный Ua',
            'partner_id' => 'Партнер',
            'alternative' => 'Связь альтернативы',
            'position' => Yii::t('app', 'Position'),
            'created_at' => Yii::t('app', 'Create time'),
            'updated_at' => Yii::t('app', 'Update time'),
            'published' => Yii::t('app', 'Published'),
            'deleted' => Yii::t('app', 'Deleted'),
            'new_price' => 'Цена требует проверки, есть новый прайс',
            'show_for_ru' => 'Показывать на ru',
            'show_for_by' => 'Показывать на by',
            'show_for_ua' => 'Показывать на ua',
        ];
    }

    /**
     * @return mixed
     */
    public static function findBase()
    {
        return self::find()->joinWith(['lang'])->orderBy(self::tableName() . '.title');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(FactoryLang::class, ['rid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasMany(Product::class, ['factory_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSale()
    {
        return $this->hasMany(Sale::class, ['factory_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCollection()
    {
        return $this->hasMany(Collection::class, ['factory_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatalogsFiles()
    {
        return $this->hasMany(FactoryCatalogsFiles::class, ['factory_id' => 'id'])
            ->andWhere(['file_type' => 1]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPricesFiles()
    {
        return $this->hasMany(FactoryPricesFiles::class, ['factory_id' => 'id'])
            ->andWhere(['file_type' => 2]);
    }

    /**
     * @return null|string
     */
    public function getImageLink()
    {
        $module = Yii::$app->getModule('catalog');

        $path = $module->getFactoryUploadPath();
        $url = $module->getFactoryUploadUrl();

        $image = null;

        if (!empty($this->image_link) && is_file($path . '/' . $this->image_link)) {
            $image = $url . '/' . $this->image_link;
        }

        return $image;
    }
}
