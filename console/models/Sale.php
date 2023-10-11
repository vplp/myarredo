<?php

namespace console\models;

/**
 * Class Sale
 *
 * @package console\models
 */
class Sale extends \frontend\modules\catalog\models\Sale
{
    /**
     * @return mixed
     */
    public static function findBase()
    {
        return self::find()
            ->joinWith(['lang'])
            ->enabled();
    }

    /**
     * @return mixed
     */
    public static function findBaseArray()
    {
        return self::findBase()
            ->asArray();
    }
}
