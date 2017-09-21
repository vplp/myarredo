<?php

namespace common\modules\shop\models;

/**
 * Class Cart
 *
 * @package common\modules\shop\models
 */
class Cart extends \thread\modules\shop\models\Cart
{
    /**
     * @return mixed
     */
    public function getItems()
    {
        return $this->hasMany(CartItem::class, ['cart_id' => 'id']);
    }
}