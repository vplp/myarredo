<?php

namespace common\modules\sys\models;

/**
 * Class Language
 *
 * @package common\modules\sys\models
 */
class Language extends \thread\modules\sys\models\Language
{
    /**
     * @return mixed
     */
    public static function findBase()
    {
        return self::find();
    }
}
