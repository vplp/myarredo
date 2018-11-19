<?php

namespace frontend\modules\news\models;

use yii\helpers\Url;
/**
 * Class Article
 *
 * @package frontend\modules\news\models
 */
class Article extends \common\modules\news\models\Article
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
    public static function find()
    {
        return parent::find()->enabled();
    }

    /**
     * @return mixed
     */
    public static function findBase()
    {
        return self::find()->innerJoinWith(["lang"])->orderBy(['published_time' => SORT_DESC]);
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
     * @param string $group
     * @return mixed
     */
    public static function findByGroupId($group = '')
    {
        return self::findBase()->group_id($group)->all();
    }

    /**
     * @param $alias
     * @return mixed
     */
    public static function findByAlias($alias)
    {
        return self::findBase()->byAlias($alias)->one();
    }

    /**
     * @param bool $scheme
     * @return string
     */
    public function getUrl($scheme = false)
    {
        return Url::toRoute(['/news/article/index', 'alias' => $this->alias], $scheme);
    }
}
