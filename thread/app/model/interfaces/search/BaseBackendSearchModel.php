<?php

namespace thread\app\model\interfaces\search;

/**
 * interface BaseBackendSearchModel
 *
 * @package thread\app\model\interfaces\search
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
interface BaseBackendSearchModel
{
    /**
     * @return mixed
     */
    public function rules();

    /**
     * @return mixed
     */
    public function scenarios();

    /**
     * @param $query
     * @param $params
     * @return mixed
     */
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