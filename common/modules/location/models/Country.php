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
            ->joinWith(['lang'])
            ->orderBy(self::tableName(). '.position');
    }

    /**
     * @param string $alias
     * @return mixed
     */
    public static function findByAlias($alias)
    {
        return self::findBase()->byAlias($alias)->one();
    }

    /**
     * @param int $id
     * @return mixed
     */
    public static function findById($id)
    {
        return self::findBase()->byId($id)->one();
    }
}
