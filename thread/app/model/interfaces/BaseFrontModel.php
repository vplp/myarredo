<?php

namespace thread\app\model\interfaces;

/**
 * interface BaseFrontModel
 *
 * @package thread\app\model\interfaces
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
interface BaseFrontModel
{
    /**
     * @return mixed
     */
    public static function find_base();

    /**
     * @param $id
     * @return mixed
     */
    public static function findById($id);

    /**
     * @param bool|false $scheme
     * @return mixed
     */
    public function getUrl($scheme = false);
}