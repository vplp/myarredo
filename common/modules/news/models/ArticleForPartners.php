<?php

namespace common\modules\news\models;

use Yii;
use yii\helpers\{
    ArrayHelper
};
//
use common\modules\news\News as NewsModule;
//
use thread\app\base\models\ActiveRecord;

/**
 * Class Article
 *
 * @property integer id
 * @property integer position
 * @property integer show_all
 * @property integer updated_at
 * @property boolean published
 * @property boolean deleted
 *
 * @property ArticleForPartnersLang $lang
 *
 * @package common\modules\news\models
 */
class ArticleForPartners extends ActiveRecord
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
        return '{{%news_article_for_partners}}';
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
            [['position', 'create_time', 'update_time'], 'integer'],
            [['show_all', 'published', 'deleted'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [['position'], 'default', 'value' => '0'],
        ];
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return [
            'show_all' => ['show_all'],
            'published' => ['published'],
            'deleted' => ['deleted'],
            'backend' => ['position', 'show_all', 'published', 'deleted'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'position' => Yii::t('app', 'Position'),
            'show_all' => Yii::t('news', 'Show all'),
            'created_at' => Yii::t('app', 'Create time'),
            'updated_at' => Yii::t('app', 'Update time'),
            'published' => Yii::t('app', 'Published'),
            'deleted' => Yii::t('app', 'Deleted'),
        ];
    }

    /**
     * @return mixed
     */
    public static function findBase()
    {
        return self::find()->joinWith(['lang'])->orderBy(self::tableName() . '.position');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(ArticleForPartnersLang::class, ['rid' => 'id']);
    }
}
