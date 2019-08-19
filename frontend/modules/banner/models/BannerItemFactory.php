<?php

namespace frontend\modules\banner\models;

/**
 * Class BannerItemFactory
 *
 * @package frontend\modules\banner\models
 */
class BannerItemFactory extends \common\modules\banner\models\BannerItemFactory
{
    /**
     * @return mixed
     */
    public static function findBase()
    {
        return parent::findBase()->enabled();
    }
}
