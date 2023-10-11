<?php

namespace thread\modules\shop\models\query;

use thread\app\base\models\query\ActiveQuery;

/**
 * Class OrderQuery
 *
 * @package thread\modules\shop\models\query
 */
class OrderQuery extends ActiveQuery
{
    /**
     * @param string $token
     * @return $this
     */
    public function token(string $token)
    {
        $modelClass = $this->modelClass;
        $this->andWhere($modelClass::tableName() . '.token = :token', [':token' => $token]);
        return $this;
    }

    /**
     * @param int $customer
     * @return $this
     */
    public function customer(int $customer)
    {
        $modelClass = $this->modelClass;
        $this->andWhere($modelClass::tableName() . '.customer_id = :customer_id', [':customer_id' => $customer]);
        return $this;
    }
}