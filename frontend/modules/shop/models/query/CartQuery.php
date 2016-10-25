<?php

namespace frontend\modules\shop\models\query;

use thread\app\base\models\query\ActiveQuery;

/**
 * Class CartQuery
 *
 * @package frontend\modules\shop\models\query
 * @author Alla Kuzmenko
 * @copyright (c), Thread
 */
class CartQuery extends ActiveQuery
{

    /**
     * @param $php_session_id
     * @return $this
     */
    public function php_session_id(string $php_session_id = '')
    {
        $modelClass = $this->modelClass;
        $this->andWhere($modelClass::tableName() . '.php_session_id = :php_session_id', [':php_session_id' => $php_session_id]);
        return $this;
    }

}
