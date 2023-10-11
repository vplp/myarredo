<?php

namespace common\modules\articles\models;

use common\modules\articles\Articles as ArticlesModule;
use common\modules\catalog\models\Specification;
//
use thread\app\base\models\ActiveRecord;

/**
 * Class ArticleRelStyles
 *
 * @property int $article_id
 * @property int $style_id
 *
 * @package common\modules\articles\models
 */
class ArticleRelStyles extends ActiveRecord
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
        return '{{%articles_article_rel_catalog_style}}';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [];
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['article_id', 'exist', 'targetClass' => Article::class, 'targetAttribute' => 'id'],
            ['style_id', 'exist', 'targetClass' => Specification::class, 'targetAttribute' => 'id'],
        ];
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return [
            'backend' => [
                'article_id',
                'style_id',
            ],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'article_id',
            'style_id',
        ];
    }

    /**
     * @param $subQuery
     * @return mixed
     */
    public static function getCounts($subQuery)
    {
        return self::find()
            ->asArray()
            ->indexBy('style_id')
            ->select('style_id, count(style_id) as count')
            ->groupBy('style_id')
            ->andWhere(['in', 'article_id', $subQuery])
            ->all();
    }
}
