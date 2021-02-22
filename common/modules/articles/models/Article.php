<?php

namespace common\modules\articles\models;

use Yii;
use yii\helpers\{
    ArrayHelper, Inflector
};
use yii\behaviors\AttributeBehavior;
use voskobovich\behaviors\ManyToManyBehavior;
use common\modules\location\models\City;
use common\modules\catalog\models\{
    Factory, Category, Types, Specification
};
use common\modules\articles\Articles as ArticlesModule;
use thread\app\base\models\ActiveRecord;

/**
 * Class Article
 *
 * @property integer $id
 * @property string $alias
 * @property integer $city_id
 * @property integer $category_id
 * @property integer $factory_id
 * @property string $image_link
 * @property integer $published_time
 * @property integer $created_at
 * @property integer $updated_at
 * @property boolean $published
 * @property boolean $deleted
 *
 * @property Category $category
 * @property Factory $factory
 * @property Types[] $types
 * @property Specification[] $styles
 * @property ArticleLang $lang
 *
 * @package common\modules\articles\models
 */
class Article extends ActiveRecord
{
    /**
     * @return object|string|\yii\db\Connection|null
     * @throws \yii\base\InvalidConfigException
     */
    public static function getDb()
    {
        return ArticlesModule::getDb();
    }

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%articles_article}}';
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
                    'types_ids' => 'types',
                    'styles_ids' => 'styles',
                ],
            ],
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
            [['city_id', 'category_id', 'factory_id', 'created_at', 'updated_at'], 'integer'],
            [
                ['published_time'],
                'date',
                'format' => 'php:' . ArticlesModule::getFormatDate(),
                'timestampAttribute' => 'published_time'
            ],
            [['published', 'deleted'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [['alias', 'image_link'], 'string', 'max' => 255],
            [['alias'], 'unique'],
            [
                [
                    'types_ids',
                    'styles_ids',
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
                'alias',
                'city_id',
                'category_id',
                'factory_id',
                'image_link',
                'published_time',
                'published',
                'deleted',
                'types_ids',
                'styles_ids',
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
            'city_id' => Yii::t('app', 'City'),
            'category_id' => Yii::t('app', 'Category'),
            'factory_id' => Yii::t('app', 'Factory'),
            'image_link' => Yii::t('app', 'Image link'),
            'published_time' => Yii::t('app', 'Published time'),
            'created_at' => Yii::t('app', 'Create time'),
            'updated_at' => Yii::t('app', 'Update time'),
            'published' => Yii::t('app', 'Published'),
            'deleted' => Yii::t('app', 'Deleted'),
            'types_ids' => Yii::t('app', 'Types'),
            'styles_ids' => Yii::t('app', 'Styles'),
        ];
    }

    /**
     * @return mixed
     */
    public static function findBase()
    {
        return self::find()->innerJoinWith(['lang'])->orderBy(['published_time' => SORT_DESC]);
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
     * @throws \yii\base\InvalidConfigException
     */
    public function getTypes()
    {
        return $this
            ->hasMany(Types::class, ['id' => 'type_id'])
            ->viaTable(ArticleRelTypes::tableName(), ['article_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getStyles()
    {
        return $this
            ->hasMany(Specification::class, ['id' => 'style_id'])
            ->viaTable(ArticleRelStyles::tableName(), ['article_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
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
    public function getLang()
    {
        return $this->hasOne(ArticleLang::class, ['rid' => 'id']);
    }

    /**
     * @return string
     */
    public function getPublishedTime()
    {
        $format = ArticlesModule::getFormatDate();
        return $this->published_time == 0 ? date($format, $this->updated_at) : date($format, $this->published_time);
    }

    /**
     *  ISO8601 = "Y-m-d\TH:i:sO"
     * @return string
     */
    public function getPublishedTimeISO()
    {
        return date('Y-m-d\TH:i:sO', $this->published_time);
    }

    /**
     * @return null|string
     */
    public function getArticleImage()
    {
        $module = Yii::$app->getModule('articles');

        $path = $module->getArticleUploadPath();
        $url = $module->getArticleUploadUrl();

        $image = null;

        if (!empty($this->image_link) && is_file($path . '/' . $this->image_link)) {
            $image = Yii::$app->getRequest()->hostInfo . $url . '/' . $this->image_link;
        }

        return $image;
    }
}
