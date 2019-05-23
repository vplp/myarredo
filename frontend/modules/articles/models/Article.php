<?php

namespace frontend\modules\articles\models;

use Yii;
use yii\helpers\Url;

/**
 * Class Article
 *
 * @package frontend\modules\articles\models
 */
class Article extends \common\modules\articles\models\Article
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
     * @param $alias
     * @return mixed
     */
    public static function findByAlias($alias)
    {
        return self::findBase()->byAlias($alias)->one();
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return Url::toRoute(['/articles/article/index', 'alias' => $this->alias]);
    }
}
