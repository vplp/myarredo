<?php

namespace common\modules\sys\modules\translation\models;

use thread\modules\sys\modules\translation\models\Source as ThreadSource;

/**
 * Class Source
 *
 * @author Andrew Kontseba - Skinwalker <andjey.skinwalker@gmail.com>
 * @package common\modules\sys\modules\translation\models
 */
class Source extends ThreadSource
{
    /**
     * @return mixed
     */
    public static function findBase()
    {
        return self::find()->joinWith(['message'])->orderBy(self::tableName() . '.id DESC');
    }
}
