<?php

namespace thread\modules\shop\interfaces;

/**
 * Interface Product
 *
 * @package thread\modules\shop\interfaces
 */
interface Product
{
    /**
     * @param $id
     * @return mixed
     */
    public static function findByID($id);

    /**
     * @return mixed
     */
    public function getPrice();

    /**
     * @param $ids
     * @return array
     */
    public static function findByIDs($ids): array;
}