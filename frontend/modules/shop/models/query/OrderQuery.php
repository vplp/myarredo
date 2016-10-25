<?php

namespace frontend\modules\shop\models\query;

use thread\app\base\models\query\ActiveQuery;

/**
 * Class OrderQuery
 *
 * @package frontend\modules\shop\models\query
 * @author Alla Kuzmenko
 * @copyright (c), Thread
 */
class OrderQuery extends ActiveQuery
{ 
    /**
     * @param $token
     * @return $this
     */
    public function token(string $token)
    {
        $modelClass = $this->modelClass;
        $this->andWhere($modelClass::tableName() . '.token = :token', [':token' => $token]);
        return $this;
    }

    /**
     * @param $customer
     * @return $this
     */
    public function customer(int $customer)
    {
        $modelClass = $this->modelClass;
        $this->andWhere($modelClass::tableName() . '.customer_id = :customer_id', [':customer_id' => $customer]);
        return $this;
    }   

}
