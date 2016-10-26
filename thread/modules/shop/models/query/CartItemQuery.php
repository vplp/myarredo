<?php

namespace thread\modules\shop\models\query;

use thread\app\base\models\query\ActiveQuery;

/**
 * Class CartItemQuery
 *
 * @package thread\modules\shop\models\query
 * @author Alla Kuzmenko
 * @copyright (c), Thread
 */
class CartItemQuery extends ActiveQuery
{

    /**
     * @param $cart_id
     * @return $this
     */
    public function cart_id(int $cart_id)
    {
        $modelClass = $this->modelClass;
        $this->andWhere($modelClass::tableName() . '.cart_id = :cart_id', [':cart_id' => $cart_id]);
        return $this;
    }

    /**
     * @param $product_id
     * @return $this
     */
    public function product_id(int $product_id)
    {
        $modelClass = $this->modelClass;
        $this->andWhere($modelClass::tableName() . '.product_id = :product_id', [':product_id' => $product_id]);
        return $this;
    }

}
