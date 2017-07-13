<?php

namespace thread\app\model\interfaces;

/**
 * interface BaseBackendModel
 *
 * @package thread\app\model\interfaces
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
interface BaseBackendModel
{
    /**
     * @param $params
     * @return mixed
     */
    public function search($params);

    /**
     * @param $params
     * @return mixed
     */
    public function trash($params);
}