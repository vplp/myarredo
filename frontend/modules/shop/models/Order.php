<?php

namespace frontend\modules\shop\models;

use common\modules\shop\models\Order as CommonOrderModel;

/**
 * Class Order
 * @package frontend\modules\shop\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @author Alla Kuzmenko
 * @copyright (c) 2016, VipDesign
 */
class Order extends CommonOrderModel
{
    /**
     *
     * @return yii\db\ActiveQuery
     */
    public static function find()
    {
        return self::find()->enabled();
    }


    /**
     *
     * @return yii\db\ActiveQuery
     */
    public static function findBase()
    {
        return self::find()->innerJoinWith(['items'/*, 'cartGoods.item', 'cartGoods.item.lang'*/]);
    }


    /**
     * @return mixed
     */
    public function getItems()
    {
        return $this->hasMany(OrderItem::class, ['order_id' => 'id']);
    }

}