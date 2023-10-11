<?php

namespace thread\modules\menu\models\query;


/**
 * class CommonQuery
 *
 * @package thread\app\base\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class ActiveQuery extends \thread\app\base\models\query\ActiveQuery
{

    /**
     * @param $parent_id
     * @return $this
     */
    public function parent_id($parent_id)
    {
        $modelClass = $this->modelClass;
        $this->andWhere($modelClass::tableName() . '.parent_id = :parent_id', [':parent_id' => $parent_id]);
        return $this;
    }

}
