<?php

namespace common\modules\location\models;

/**
 * Class Country
 *
 * @package common\modules\location\models
 */
class Country extends \thread\modules\location\models\Country
{
    /**
     * @return mixed
     */
    public static function findBase()
    {
        return self::find()
            ->innerJoinWith(['lang'])
            ->orderBy(self::tableName(). '.position');
    }
}
