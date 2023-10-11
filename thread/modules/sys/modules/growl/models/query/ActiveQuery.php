<?php

namespace thread\modules\sys\modules\growl\models\query;

use thread\app\base\models\ActiveRecord;
//
use thread\app\base\models\query\ActiveQuery as AQuery;

/**
 * Class ActiveQuery
 *
 * @package thread\modules\sys\modules\growl\models\query
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class ActiveQuery extends AQuery
{

    /**
     * @return $this
     */
    public function is_read()
    {
        /** @var ActiveRecord $modelClass */
        $modelClass = $this->modelClass;
        $this->andWhere($modelClass::tableName() . '.is_read = :is_read', [':is_read' => ActiveRecord::STATUS_KEY_ON]);
        return $this;
    }

    /**
     * @return $this
     */
    public function isnt_read()
    {
        /** @var ActiveRecord $modelClass */
        $modelClass = $this->modelClass;
        $this->andWhere($modelClass::tableName() . '.is_read = :is_read', [':is_read' => ActiveRecord::STATUS_KEY_OFF]);
        return $this;
    }
}
