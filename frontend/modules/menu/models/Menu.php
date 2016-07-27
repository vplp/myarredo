<?php

namespace frontend\modules\menu\models;

/**
 * Class Menu
 *
 * @package frontend\modules\menu\models
 * @author Andrii Bondarchuk
 * @copyright (c) 2016
 */
final class Menu extends \backend\modules\menu\models\Menu {

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
        return self::find()->innerJoinWith(["lang"])->enabled();
    }

    /**
     *
     * @param string $alias
     * @return ActiveRecord|null
     */
    public static function findByAlias($alias) {
        return self::find_base()->alias($alias)->one();
    }

}
