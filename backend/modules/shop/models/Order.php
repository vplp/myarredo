<?php

namespace backend\modules\shop\models;

use thread\app\model\interfaces\BaseBackendModel;
//
use common\modules\shop\models\Order as CommonOrderModel;

/**
 * Class Order
 *
 * @package backend\modules\shop\models
 */
class Order extends CommonOrderModel implements BaseBackendModel
{
    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
        return (new search\Order())->search($params);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function trash($params)
    {
        return (new search\Order())->trash($params);
    }

    /**
     * @return mixed
     */
    public function getItems()
    {
        return $this->hasMany(OrderItem::class, ['order_id' => 'id']);
    }
}
