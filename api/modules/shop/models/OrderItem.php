<?php

namespace api\modules\shop\models;

/**
 * Class OrderItem
 *
 * @package api\modules\shop\models
 */
class OrderItem extends \backend\modules\shop\models\OrderItem
{

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
        return (new search\OrderItem())->search($params);
    }

}
