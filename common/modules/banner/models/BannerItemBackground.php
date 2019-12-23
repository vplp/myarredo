<?php

namespace common\modules\banner\models;

/**
 * Class BannerItemBackground
 *
 * @package common\modules\banner\models
 */
class BannerItemBackground extends BannerItem
{
    /**
     * @return mixed
     */
    public static function findBase()
    {
        return self::find()
            ->joinWith(['lang'])
            ->where(['type' => 'background']);
    }
}
