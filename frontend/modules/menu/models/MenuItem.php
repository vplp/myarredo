<?php

namespace frontend\modules\menu\models;

use yii\helpers\Url;

/**
 * Class Item
 *
 * @package frontend\modules\menu\models
 * @author Andrii Bondarchuk
 * @copyright (c) 2016
 */
final class MenuItem extends \backend\modules\menu\models\MenuItem
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
    public static function find_base()
    {
        return self::find()->innerJoinWith(["lang"])->enabled()->orderBy(['position' => SORT_ASC]);
    }

    /**
     *
     * @param string $group
     * @return array|null
     */
    public static function findAllByGroup($group = '', $parent = 0)
    {
        return self::find_base()->group_id($group)->parent_id($parent)->all();
    }

}
