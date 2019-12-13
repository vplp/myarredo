<?php

namespace common\modules\banner\models;

/**
 * Class BannerItemFactory
 *
 * @package common\modules\banner\models
 */
class BannerItemFactory extends BannerItem
{
    /**
     * @return mixed
     */
    public static function findBase()
    {
        return self::find()
            ->joinWith(['lang'])
            ->where(['type' => 'factory'])
            ->orderBy('position');
    }
}
