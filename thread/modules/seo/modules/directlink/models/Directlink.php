<?php

namespace thread\modules\seo\modules\directlink\models;

use Yii;

//
use thread\app\base\models\ActiveRecord;
use thread\modules\seo\helpers\CommonFunc;
use thread\modules\seo\modules\directlink\Directlink as ParentModule;

/**
 * Class Directlink
 *
 * @property integer $id
 * @property string $url
 * @property integer $meta_robots
 * @property boolean $add_to_sitemap
 * @property boolean $dissallow_in_robotstxt
 * @property string $image_url
 * @property integer $created_at
 * @property integer $updated_at
 * @property boolean $published
 * @property boolean $deleted
 * @property boolean $mark
 *
 * @package thread\modules\seo\modules\directlink\models
 */
class Directlink extends ActiveRecord
{
    /**
     * @var
     */
    public static $commonQuery = query\ActiveQuery::class;

    /**
     * @return null|object|\yii\db\Connection
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
        return '{{%seo_direct_link}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['url'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [
                [
                    'published',
                    'deleted',
                    'add_to_sitemap',
                    'dissallow_in_robotstxt',
                    'mark'
                ],
                'in',
                'range' => array_keys(static::statusKeyRange())
            ],
            [['meta_robots'], 'in', 'range' => array_keys(static::statusMetaRobotsRange())],
            [['url', 'title', 'description', 'keywords', 'image_url'], 'string', 'max' => 255],
            [['url'], 'unique']
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
            'mark' => ['mark'],
            'dissallow_in_robotstxt' => ['dissallow_in_robotstxt'],
            'backend' => [
                'url',
                'published',
                'deleted',
                'add_to_sitemap',
                'dissallow_in_robotstxt',
                'meta_robots',
                'title',
                'description',
                'keywords',
                'image_url',
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
            'url' => Yii::t('app', 'Link'),
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
            'mark'
        ];
    }

    /**
     * @return array
     */
    public static function statusMetaRobotsRange()
    {
        return CommonFunc::statusMetaRobotsRange();
    }
}
