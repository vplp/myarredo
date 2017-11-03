<?php

namespace frontend\modules\menu\models;

use thread\app\model\interfaces\BaseFrontModel;

/**
 * Class Menu
 *
 * @package frontend\modules\menu\models
 */
final class Menu extends \common\modules\menu\models\Menu implements BaseFrontModel
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
        return parent::find()->enabled()->innerJoinWith(["lang"]);
    }

    /**
     * @return mixed
     */
    public static function findBase()
    {
        return self::find();
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function findById($id)
    {
        return self::findBase()->byID($id);
    }

    /**
     * @param $alias
     * @return mixed
     */
    public static function findByAlias($alias)
    {
        return self::findBase()->byAlias($alias);
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function getById($id)
    {
        return self::findById($id)->one();
    }

    /**
     * @param $alias
     * @return mixed
     */
    public static function getByAlias($alias)
    {
        return self::findByAlias($alias)->one();
    }

    /**
     * @param bool|false $scheme
     */
    public function getUrl($scheme = false)
    {
        // TODO: Implement getUrl() method.
    }

}
