<?php

namespace frontend\modules\shop\models;

use common\modules\shop\models\Cart as CommonCartModel;



/**
 * Class Cart
 * @package frontend\modules\shop\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @author Alla Kuzmenko
 * @copyright (c) 2016, VipDesign
 */
class Cart extends CommonCartModel
{
   
     
    /**
     * @return mixed
     */
    public function getItems()
    {
        return $this->hasMany(CartItem::class, ['cart_id' => 'id']);
    }



}