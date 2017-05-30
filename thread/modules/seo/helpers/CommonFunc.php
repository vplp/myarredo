<?php

namespace thread\modules\seo\helpers;

use thread\app\base\models\ActiveRecord;

/**
 * Class CommonFunc
 *
 * @package thread\modules\seo\helpers
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class CommonFunc
{
    /**
     * @return array
     */
    public static function statusMetaRobotsRange()
    {
        return [
            1 => 'index, follow',
            2 => 'index, nofollow',
            3 => 'noindex, follow',
            4 => 'noindex, nofollow'
        ];
    }

    /**
     * @param ActiveRecord $model
     * @return string
     */
    public static function getModelKey(ActiveRecord $model)
    {
        return sha1($model::tableName());
    }
}