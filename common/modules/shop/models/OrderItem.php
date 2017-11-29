<?php

namespace common\modules\shop\models;


use common\modules\catalog\models\Product;

/**
 * Class OrderItem
 *
 * @package common\modules\shop\models
 */
class OrderItem extends \thread\modules\shop\models\OrderItem
{

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }
}