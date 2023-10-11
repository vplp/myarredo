<?php

namespace thread\modules\shop\models\query;

use thread\app\base\models\query\ActiveQuery;

/**
 * Class CartQuery
 *
 * @package thread\modules\shop\models\query
 */
class CartQuery extends ActiveQuery
{
    /**
     * @param string $php_session_id
     * @return $this
     */
    public function php_session_id(string $php_session_id = '')
    {
        $modelClass = $this->modelClass;
        $this->andWhere($modelClass::tableName() . '.php_session_id = :php_session_id', [':php_session_id' => $php_session_id]);
        return $this;
    }
}