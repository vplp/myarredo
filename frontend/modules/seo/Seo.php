<?php

namespace frontend\modules\seo;

use frontend\modules\seo\modules\{
    sitemap\Sitemap, pathcache\Pathcache
};

/**
 * Class Seo
 *
 * @package frontend\modules\seo
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Seo extends \thread\modules\seo\Seo
{
    /**
     *
     */
    public function init()
    {

        $this->modules = [
            'pathcache' => [
                'class' => Pathcache::class,
            ],
            'sitemap' => [
                'class' => Sitemap::class
            ]
        ];

        parent::init();
    }
}
