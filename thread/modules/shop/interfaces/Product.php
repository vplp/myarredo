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
     * @param integer $id
     * @return Product
     */
    public static function findByID(integer $id);
    
    /**
     * 
     * @return float
     */
    public function getPrice();
   

}