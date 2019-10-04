<?php

namespace console\models;

/**
 * Class ItalianProduct
 *
 * @package console\models
 */
class ItalianProduct extends \frontend\modules\catalog\models\ItalianProduct
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
