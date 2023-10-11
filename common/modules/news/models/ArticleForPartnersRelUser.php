<?php

namespace common\modules\news\models;

use thread\app\base\models\ActiveRecord;
//
use common\modules\news\News as NewsModule;
use common\modules\user\models\User;

/**
 * Class ArticleForPartnersRelUser
 *
 * @property string $article_id
 * @property string $user_id
 *
 * @package common\modules\news\models
 */
class ArticleForPartnersRelUser extends ActiveRecord
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
        return '{{%news_article_for_partners_rel_user}}';
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
            ['user_id', 'exist', 'targetClass' => User::class, 'targetAttribute' => 'id'],
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
                'user_id',
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
            'user_id',
        ];
    }
}
