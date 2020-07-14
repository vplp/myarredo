<?php

namespace common\modules\seo\models;

use Yii;
use thread\app\base\models\ActiveRecord;
use common\modules\seo\Seo as SeoModule;

/**
 * Class Redirects
 *
 * @property integer $id
 * @property string $url_from
 * @property string $url_to
 * @property integer $created_at
 * @property integer $updated_at
 * @property boolean $published
 * @property boolean $deleted
 *
 * @package common\modules\seo\models
 */
class Redirects extends ActiveRecord
{
    /**
     * @return null|object|\yii\db\Connection
     * @throws \yii\base\InvalidConfigException
     */
    public static function getDb()
    {
        return SeoModule::getDb();
    }

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%seo_redirects}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['url_from', 'url_to'], 'required'],
            [['create_at', 'update_at', 'position'], 'integer'],
            [['published', 'deleted'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [['url_from', 'url_to'], 'string', 'max' => 512],
            [['url_from'], 'unique']
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
            'backend' => ['url_from', 'url_to', 'published', 'deleted'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'url_from',
            'url_to',
            'created_at' => Yii::t('app', 'Create time'),
            'updated_at' => Yii::t('app', 'Update time'),
            'published' => Yii::t('app', 'Published'),
            'deleted' => Yii::t('app', 'Deleted')
        ];
    }
}
