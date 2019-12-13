<?php

namespace common\modules\banner\models;

/**
 * Class BannerItemMain
 *
 * @package common\modules\banner\models
 */
class BannerItemMain extends BannerItem
{
    /**
     * @return mixed
     */
    public static function findBase()
    {
        return self::find()
            ->joinWith(["lang"])
            ->where(['type' => 'main'])
            ->orderBy('position');
    }
}
