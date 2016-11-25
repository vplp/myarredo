<?php

namespace thread\modules\sys\modules\messages\models\query;

/**
 * Class ActiveQuery
 *
 * @package thread\modules\sys\modules\messages\models\query
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class ActiveQuery extends \thread\app\base\models\query\ActiveQuery
{

    /**
     * @param $filepath
     * @return $this
     */
    public function messagefilepath($filepath)
    {
        $modelClass = $this->modelClass;
        $this->andWhere($modelClass::tableName() . '.messagefilepath = :messagefilepath', [':messagefilepath' => $filepath]);
        return $this;
    }

}
