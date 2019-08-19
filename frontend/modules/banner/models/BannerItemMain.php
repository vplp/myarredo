<?php

namespace frontend\modules\banner\models;

/**
 * Class BannerItemMain
 *
 * @package frontend\modules\banner\models
 */
class BannerItemMain extends \common\modules\banner\models\BannerItemMain
{
    /**
     * @return mixed
     */
    public static function findBase()
    {
        return parent::findBase()->enabled();
    }
}
