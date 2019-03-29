<?php

namespace common\modules\articles\models;

use common\modules\articles\Articles as ArticlesModule;
use common\modules\catalog\models\Types;
//
use thread\app\base\models\ActiveRecord;

/**
 * Class ArticleRelTypes
 *
 * @property int $article_id
 * @property int $type_id
 *
 * @package common\modules\catalog\models
 */
class ArticleRelTypes extends ActiveRecord
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
        return '{{%articles_article_rel_catalog_type}}';
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
            ['type_id', 'exist', 'targetClass' => Types::class, 'targetAttribute' => 'id'],
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
                'type_id',
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
            'type_id',
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
            ->indexBy('type_id')
            ->select('type_id, count(type_id) as count')
            ->groupBy('type_id')
            ->andWhere(['in', 'article_id', $subQuery])
            ->all();
    }
}
