<?php

namespace frontend\modules\banner\models;

/**
 * Class BannerItemFactory
 *
 * @package frontend\modules\banner\models
 */
class BannerItemCatalog extends \common\modules\banner\models\BannerItemCatalog
{
    /**
     * @return mixed
     */
    public static function findBase()
    {
        return parent::findBase()->enabled();
    }
}
