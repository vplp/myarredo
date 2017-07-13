<?php

namespace thread\modules\shop\interfaces;

/**
 * interface Product
 *
 * @package thread\modules\shop\interfaces
 * @author Alla Kuzmenko
 * @copyright (c), Thread
 */
interface Product
{
    /**
     * @param $id
     * @return Product
     */
    public static function findByID($id);
    
    /**
     * 
     * @return float
     */
    public function getPrice();

    /**
     * @param $ids
     * @return array
     */
    public static function findByIDs($ids):array;

}