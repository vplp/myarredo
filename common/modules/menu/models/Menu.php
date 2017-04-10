<?php

namespace common\modules\menu\models;

/**
 * Class Menu
 *
 * @package common\modules\menu\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Menu extends \thread\modules\menu\models\Menu
{
    /**
     * @param $id
     */
    public static function getById($id)
    {
        return self::find()->byID($id)->one();
    }
}
