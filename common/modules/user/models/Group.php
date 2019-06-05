<?php

namespace common\modules\user\models;

/**
 * Class Group
 *
 * @package common\modules\user\models
 */
class Group extends \thread\modules\user\models\Group
{
    const PARTNER = 4;
    const FACTORY = 3;
    const LOQISTICIAN = 7;

    /**
     * @return mixed
     */
    public static function findBase()
    {
        return self::find()->joinWith(['lang']);
    }
}
