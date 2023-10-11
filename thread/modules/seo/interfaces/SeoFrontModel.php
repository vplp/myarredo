<?php

namespace thread\modules\seo\interfaces;

/**
 * Interface SeoFrontModel
 *
 * @package thread\modules\seo\interfaces
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
interface SeoFrontModel
{
    /**
     * @param bool|false $scheme
     * @return mixed
     */
    public function getUrl($scheme = false);

    /**
     * @return mixed
     */
    public static function findSeo();
}