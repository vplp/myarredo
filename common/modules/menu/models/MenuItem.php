<?php

namespace common\modules\menu\models;

/**
 * Class MenuItem
 *
 * @package common\modules\menu\models
 */
class MenuItem extends \thread\modules\menu\models\MenuItem
{
    /**
     * @return mixed
     */
    public static function findBase()
    {
        return self::find()->innerJoinWith(['lang'])->orderBy(['position' => SORT_ASC]);
    }
}
