<?php

namespace frontend\modules\news\models;

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
    public static function findBase()
    {
        $query = parent::findBase()->enabled();

        $query->andFilterWhere([
            'or',
            [self::tableName() . '.show_all' => '1'],
        ]);

        return $query;
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
