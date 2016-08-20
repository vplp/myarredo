<?php
namespace thread\modules\seo\models;

use Yii;
//
use thread\app\base\models\ActiveRecord;

/**
 * Class SitemapElement
 *
 * @package app\modules\sitemap\models;
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class SitemapElement extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function getDb()
    {
        return \thread\modules\seo\Seo::getDb();
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%seo_sitemap_element}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['module_id', 'model_id', 'key', 'url'], 'required'],
            [['url'], 'string', 'max' => 2048],
            [['created_at', 'updated_at'], 'integer'],
            [['published', 'deleted'], 'in', 'range' => array_keys(self::statusKeyRange())],
            [['module_id', 'model_id'], 'string', 'max' => 255],
            [['key'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'default' => ['module_id', 'model_id', 'key', 'url'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'module_id' => Yii::t('app', 'Module'),
            'model_id' => Yii::t('app', 'Model'),
            'key' => Yii::t('app', 'Key'),
            'url' => Yii::t('app', 'Link'),
            'created_at' => Yii::t('app', 'Create time'),
            'updated_at' => Yii::t('app', 'Update time'),
            'published' => Yii::t('app', 'Published'),
            'deleted' => Yii::t('app', 'Deleted'),
        ];
    }
}
