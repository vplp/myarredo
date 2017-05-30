<?php

namespace frontend\modules\seo\modules\sitemap\models;

/**
 * Class Element
 *
 * @package frontend\modules\seo\modules\sitemap\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Element extends \common\modules\seo\modules\sitemap\models\Element
{
    /**
     * @return mixed
     */
    public static function find()
    {
        return parent::find();
    }

    /**
     * @return mixed
     */
    public static function findAddToSitemap()
    {
        return self::find()->add_to_sitemap();
    }
}
