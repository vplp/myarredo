<?php

namespace frontend\modules\news\models;

use Yii;
use yii\helpers\Url;
//
use thread\app\model\interfaces\BaseFrontModel;

/**
 * Class Article
 *
 * @package frontend\modules\news\models
 * @author Andrii Bondarchuk
 * @copyright (c) 2016
 */
class Article extends \backend\modules\news\models\Article implements BaseFrontModel
{

    /**
     *
     * @return array
     */
    public function behaviors()
    {
        return [];
    }

    /**
     *
     * @return array
     */
    public function scenarios()
    {
        return [];
    }

    /**
     *
     * @return array
     */
    public function attributeLabels()
    {
        return [];
    }

    /**
     *
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
     *
     * @param integer $id
     * @return ActiveRecord|null
     */
    public static function findById($id)
    {
        return self::findBase()->byID($id)->one();
    }

    /**
     *
     * @param integer $group_id
     * @return ActiveRecord|null
     */
    public static function findByGroupId($group = '')
    {
        return self::findBase()->group_id($group)->all();
    }

    /**
     *
     * @param string $alias
     * @return ActiveRecord|null
     */
    public static function findByAlias($alias)
    {
        return self::findBase()->byAlias($alias)->one();
    }

    /**
     *
     * @return string
     */
    public function getUrl($scheme = false)
    {
        return Url::toRoute(['/news/article/index', 'alias' => $this->alias], $scheme);
    }

}
