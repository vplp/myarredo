<?php

namespace thread\modules\seo\modules\pathcache\models\query;

/**
 * Class ActiveQuery
 *
 * @package thread\modules\seo\modules\pathcache\models\query
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class ActiveQuery extends \thread\app\base\models\query\ActiveQuery
{

    /**
     * @param string $model_key
     * @return $this
     */
    public function model_key(string $model_key)
    {
        $modelClass = $this->modelClass;
        $this->andWhere($modelClass::tableName() . '.model_key = :model_key', [':model_key' => $model_key]);
        return $this;
    }

    /**
     * @param string $classname
     * @return $this
     */
    public function _classname(string $classname)
    {
        $modelClass = $this->modelClass;
        $this->andWhere($modelClass::tableName() . '.classname = :classname', [':classname' => $classname]);
        return $this;
    }
}