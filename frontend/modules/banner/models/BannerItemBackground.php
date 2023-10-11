<?php

namespace frontend\modules\banner\models;

/**
 * Class BannerItemBackground
 *
 * @package frontend\modules\banner\models
 */
class BannerItemBackground extends \common\modules\banner\models\BannerItemBackground
{
    /**
     * @return mixed
     */
    public static function findBase()
    {
        return parent::findBase()->enabled();
    }
}
