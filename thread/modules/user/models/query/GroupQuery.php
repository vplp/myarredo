<?php

namespace thread\modules\user\models\query;

use thread\app\base\models\query\ActiveQuery;

/**
 * Class GroupQuery
 *
 * @package thread\modules\user\models\query
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class GroupQuery extends ActiveQuery
{

    /**
     * @param string $role
     * @return $this
     */
    public function role(string $role)
    {
        $modelClass = $this->modelClass;
        $this->andWhere($modelClass::tableName() . '.role = :role', [':role' => $role]);
        return $this;
    }

}
