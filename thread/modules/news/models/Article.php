<?php

namespace thread\modules\news\models;

use Yii;
use yii\helpers\{
    ArrayHelper, Inflector
};
use yii\behaviors\AttributeBehavior;
use voskobovich\behaviors\ManyToManyBehavior;
use thread\modules\location\models\City;
use common\modules\catalog\models\{
    Factory, Category, Types, Specification
};
use thread\app\base\models\ActiveRecord;
use thread\modules\news\News as NewsModule;

/**
 * Class Article
 *
 * @property integer $id
 * @property integer $group_id
 * @property string $alias
 * @property integer $category_id
 * @property integer $factory_id
 * @property string $image_link
 * @property string $gallery_image
 * @property integer $published_time
 * @property integer $created_at
 * @property integer $updated_at
 * @property boolean $published
 * @property boolean $deleted
 * @property boolean $mark
 *
 * @property Category $category
 * @property Factory $factory
 * @property Types[] $types
 * @property Specification[] $styles
 * @property City[] $cities
 * @property Group $group
 * @property ArticleLang $lang
 *
 * @package thread\modules\news\models
 */
class Article extends ActiveRecord
{
    /**
     * @return null|object|\yii\db\Connection
     * @throws \yii\base\InvalidConfigException
     */
    public static function getDb()
    {
        return NewsModule::getDb();
    }

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%news_article}}';
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
                    'city_ids' => 'cities',
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
            [['category_id', 'factory_id', 'group_id', 'create_time', 'update_time'], 'integer'],
            [
                ['published_time'],
                'date',
                'format' => 'php:' . NewsModule::getFormatDate(),
                'timestampAttribute' => 'published_time'
            ],
            [['published', 'deleted', 'mark'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [['alias', 'image_link'], 'string', 'max' => 255],
            [['gallery_image'], 'string', 'max' => 1024],
            [['alias'], 'unique'],
            [
                [
                    'types_ids',
                    'styles_ids',
                    'city_ids',
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
            'mark' => ['mark'],
            'backend' => [
                'category_id',
                'factory_id',
                'group_id',
                'alias',
                'image_link',
                'gallery_image',
                'published',
                'deleted',
                'published_time',
                'types_ids',
                'styles_ids',
                'city_ids',
                'mark'
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
            'group_id' => Yii::t('app', 'Group'),
            'alias' => Yii::t('app', 'Alias'),
            'category_id' => Yii::t('app', 'Category'),
            'factory_id' => Yii::t('app', 'Factory'),
            'image_link' => Yii::t('app', 'Image link'),
            'gallery_image' => Yii::t('app', 'Gallery image'),
            'published_time' => Yii::t('app', 'Published time'),
            'created_at' => Yii::t('app', 'Create time'),
            'updated_at' => Yii::t('app', 'Update time'),
            'published' => Yii::t('app', 'Published'),
            'deleted' => Yii::t('app', 'Deleted'),
            'date_from' => Yii::t('news', 'Date from'),
            'date_to' => Yii::t('news', 'Date to'),
            'types_ids' => Yii::t('app', 'Types'),
            'styles_ids' => Yii::t('app', 'Styles'),
            'city_ids' => Yii::t('app', 'Cities'),
            'mark'
        ];
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (in_array($this->scenario, ['backend'])) {
            $this->mark = '0';
        }

        return parent::beforeSave($insert);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(Group::class, ['id' => 'group_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(ArticleLang::class, ['rid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getCities()
    {
        return $this
            ->hasMany(City::class, ['id' => 'city_id'])
            ->viaTable(ArticleRelCity::tableName(), ['article_id' => 'id']);
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
     * @return string
     */
    public function getPublishedTime()
    {
        $format = NewsModule::getFormatDate();
        return $this->published_time == 0 ? date($format) : date($format, $this->published_time);
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
        $module = Yii::$app->getModule('news');
        $path = $module->getArticleUploadPath();
        $url = $module->getArticleUploadUrl();
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
        $module = Yii::$app->getModule('news');

        $path = $module->getArticleUploadPath();
        $url = $module->getArticleUploadUrl();

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
}
