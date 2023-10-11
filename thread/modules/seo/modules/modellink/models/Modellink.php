<?php

namespace thread\modules\seo\modules\modellink\models;

use Yii;
//
use thread\app\base\models\ActiveRecord;
use thread\modules\seo\helpers\CommonFunc;
use thread\modules\seo\modules\modellink\Modellink as ParentModule;

/**
 * Class Modellink
 *
 * @package thread\modules\seo\modules\modellink\models
 */
class Modellink extends ActiveRecord
{
    /**
     * @var
     */
    public static $commonQuery = query\ActiveQuery::class;

    /**
     * @return object|\yii\db\Connection|null
     * @throws \yii\base\InvalidConfigException
     */
    public static function getDb()
    {
        return ParentModule::getDb();
    }

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%seo_model_link}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['model_key', 'model_id', 'lang'], 'required'],
            [['created_at', 'updated_at', 'model_id'], 'integer'],
            [
                ['published', 'deleted', 'add_to_sitemap', 'dissallow_in_robotstxt'],
                'in',
                'range' => array_keys(static::statusKeyRange())
            ],
            [['meta_robots'], 'in', 'range' => array_keys(static::statusMetaRobotsRange())],
            [['title', 'description', 'keywords', 'image_url'], 'string', 'max' => 255],
            [['lang'], 'string', 'max' => 5],
            [['model_key'], 'string', 'max' => 40],
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
            'add_to_sitemap' => ['add_to_sitemap'],
            'dissallow_in_robotstxt' => [
                'dissallow_in_robotstxt'
            ],
            'backend' => [
                'model_key',
                'model_id',
                'lang',
                'published',
                'deleted',
                'add_to_sitemap',
                'dissallow_in_robotstxt',
                'meta_robots',
                'title',
                'description',
                'keywords',
                'image_url'
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
            'model_key' => Yii::t('seo', 'Model key'),
            'model_id' => Yii::t('seo', 'Model id'),
            'lang' => Yii::t('app', 'Language'),
            'add_to_sitemap' => Yii::t('seo', 'Add to sitemap'),
            'dissallow_in_robotstxt' => Yii::t('seo', 'Dissallow in robots.txt'),
            'meta_robots' => Yii::t('seo', 'Robots'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'keywords' => Yii::t('seo', 'Keywords'),
            'image_url' => Yii::t('seo', 'Image url'),
            'created_at' => Yii::t('app', 'Create time'),
            'updated_at' => Yii::t('app', 'Update time'),
            'published' => Yii::t('app', 'Published'),
            'deleted' => Yii::t('app', 'Deleted'),
        ];
    }

    /**
     * @return array
     */
    public static function statusMetaRobotsRange()
    {
        return CommonFunc::statusMetaRobotsRange();
    }

    /**
     * @param ActiveRecord $model
     * @return string
     */
    public static function getModelKey(ActiveRecord $model)
    {
        return CommonFunc::getModelKey($model);
    }

    /**
     * @param string $model_key
     * @param int $model_id
     * @return mixed
     */
    public static function findModel(string $model_key, int $model_id)
    {
        return self::find()->model_key($model_key)->model_id($model_id)->currency_language();
    }
}
