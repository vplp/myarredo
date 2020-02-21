<?php

namespace frontend\modules\news\models;

use Yii;
use yii\helpers\Url;

/**
 * Class ArticleForPartners
 *
 * @package frontend\modules\news\models
 */
class ArticleForPartners extends \common\modules\news\models\ArticleForPartners
{

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
    public function scenarios()
    {
        return [];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [];
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [];
    }

    /**
     * @return mixed
     */
    public static function findListForPartners()
    {
        $subQueryUser = ArticleForPartnersRelUser::find()
            ->select('article_id')
            ->andWhere([ArticleForPartnersRelUser::tableName() . '.user_id' => Yii::$app->user->identity->id]);

        $subQueryCity = ArticleForPartnersRelCity::find()
            ->select('article_id')
            ->andWhere([ArticleForPartnersRelCity::tableName() . '.city_id' => Yii::$app->user->identity->profile->city_id]);

        $query = self::findBase()
            ->andFilterWhere([
                'OR',
                [self::tableName() . '.show_all' => '1'],
                ['in', self::tableName() . '.id', $subQueryUser],
                ['in', self::tableName() . '.id', $subQueryCity]
            ])
            ->limit(3)
            ->all();

        return $query;
    }

    /**
     * @return mixed
     */
    public static function findBase()
    {
        return parent::findBase()->enabled();
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function findById($id)
    {
        return self::findBase()->byID($id)->one();
    }

    /**
     * @param bool $scheme
     * @return mixed|string
     */
    public function getUrl($scheme = false)
    {
        return Url::toRoute(['/news/article-for-partners/index', 'id' => $this->id], $scheme);
    }
}
