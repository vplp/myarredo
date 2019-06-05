<?php

namespace common\modules\menu\models;

/**
 * Class Menu
 *
 * @package common\modules\menu\models
 */
class Menu extends \thread\modules\menu\models\Menu
{
    /**
     * @return mixed
     */
    public static function findBase()
    {
        return self::find()->joinWith(['lang']);
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function getById($id)
    {
        return self::find()->byID($id)->one();
    }
}
