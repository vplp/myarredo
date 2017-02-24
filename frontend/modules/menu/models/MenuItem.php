<?php

namespace frontend\modules\menu\models;

use thread\app\model\interfaces\BaseFrontModel;
//
use common\modules\menu\models\MenuItem as cMeniItem;

/**
 * Class Item
 *
 * @package frontend\modules\menu\models
 * @author Andrii Bondarchuk
 * @copyright (c) 2016
 */
final class MenuItem extends cMeniItem implements BaseFrontModel
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

    public static function find()
    {
        return parent::find()->enabled();
    }

    /**
     * @return mixed
     */
    public static function findBase()
    {
        return self::find()->innerJoinWith(["lang"])->orderBy(['position' => SORT_ASC]);
    }

    /**
     *
     * @param string $group
     * @return array|null
     */
    public static function findAllByGroup($group = '', $parent = 0)
    {
        return self::findBase()->group_id($group)->parent_id($parent)->all();
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
     * @param $id
     * @return mixed
     */
    public static function findById($id)
    {
        return self::findBase()->byID($id)->one();
    }

    /**
     * @param bool|false $scheme
     */
    public function getUrl($scheme = false)
    {
        // TODO: Implement getUrl() method.
    }

}
