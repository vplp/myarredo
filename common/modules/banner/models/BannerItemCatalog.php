<?php

namespace common\modules\banner\models;

/**
 * Class BannerItemCatalog
 *
 * @package common\modules\banner\models
 */
class BannerItemCatalog extends BannerItem
{
    /**
     * @return mixed
     */
    public static function findBase()
    {
        return self::find()
            ->joinWith(['lang'])
            ->where(['type' => 'catalog'])
            ->orderBy('position');
    }
}
