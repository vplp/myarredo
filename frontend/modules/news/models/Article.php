<?php

namespace frontend\modules\news\models;

use yii\helpers\Url;
use Yii;

/**
 * Class Article
 *
 * @package frontend\modules\news\models
 * @author Andrii Bondarchuk
 * @copyright (c) 2016
 */
class Article extends \backend\modules\news\models\Article {

    /**
     * 
     * @return array
     */
    public function behaviors() {
        return [];
    }

    /**
     * 
     * @return array
     */
    public function scenarios() {
        return [];
    }

    /**
     * 
     * @return array
     */
    public function attributeLabels() {
        return [];
    }

    /**
     * 
     * @return array
     */
    public function rules() {
        return [];
    }

    /**
     *
     * @return yii\db\ActiveQuery
     */
    public static function find_base() {
        return self::find()->innerJoinWith(["lang"])->enabled()->orderBy(['published_time' => SORT_DESC]);
    }

    /**
     *
     * @param integer $id
     * @return ActiveRecord|null
     */
    public static function findById($id) {
        return self::find_base()->byID($id)->one();
    }

    /**
     *
     * @param integer $group_id
     * @return ActiveRecord|null
     */
    public static function findByGroupId($group = '') {
        return self::find_base()->/*group_id($group)->*/all();
    }

    /**
     *
     * @param string $alias
     * @return ActiveRecord|null
     */
    public static function findByAlias($alias) {
        return self::find_base()->alias($alias)->one();
    }

    /**
     *
     * @return string
     */
    public function getUrl() {
        return Url::toRoute(['/news/article/index', 'alias' => $this->alias]);
    }

}
