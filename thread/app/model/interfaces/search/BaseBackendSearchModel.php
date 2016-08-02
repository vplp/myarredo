<?php

namespace thread\app\model\interfaces\search;

/**
 * interface BaseBackendSearchModel
 *
 * @package thread\app\model\interfaces\search
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
interface BaseBackendSearchModel
{
    public function rules();

    public function scenarios();

    public function baseSearch($query, $params);
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