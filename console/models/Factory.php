<?php

namespace console\models;

/**
 * Class Factory
 *
 * @package console\models
 */
class Factory extends \frontend\modules\catalog\models\Factory
{
    /**
     * @return mixed
     */
    public static function findBase()
    {
        return self::find()
            ->joinWith(['lang'])
            ->orderBy(self::tableName() . '.title')
            ->enabled();
    }
}
