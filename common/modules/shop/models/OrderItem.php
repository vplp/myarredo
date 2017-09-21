<?php

namespace common\modules\shop\models;

use common\modules\catalog\models\GoodsServices;

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
        return $this->hasOne(GoodsServices::class, ['id' => 'product_id']);
    }
}