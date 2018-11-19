<?php

namespace common\modules\news\models;

use thread\app\base\models\ActiveRecord;
//
use common\modules\news\News as NewsModule;
use common\modules\location\models\City;

/**
 * Class ArticleForPartnersRelCity
 *
 * @property string $article_id
 * @property string $city_id
 *
 * @package common\modules\news\models
 */
class ArticleForPartnersRelCity extends ActiveRecord
{
    /**
     * @return null|object|string|\yii\db\Connection
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
        return '{{%news_article_for_partners_rel_city}}';
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
            ['article_id', 'exist', 'targetClass' => ArticleForPartners::class, 'targetAttribute' => 'id'],
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
