<?php

namespace common\modules\articles\models;

use common\modules\articles\Articles as ArticlesModule;
use common\modules\location\models\City;
use thread\app\base\models\ActiveRecord;

/**
 * Class ArticleRelCity
 *
 * @property int $article_id
 * @property int $city_id
 *
 * @package common\modules\articles\models
 */
class ArticleRelCity extends ActiveRecord
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
        return '{{%articles_article_rel_city}}';
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
            ['city_id', 'exist', 'targetClass' => City::class, 'targetAttribute' => 'id'],
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
                'city_id',
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
            'city_id',
        ];
    }
}
