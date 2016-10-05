<?php

namespace thread\modules\user\models\query;

use thread\app\base\models\ActiveRecord;
use thread\app\base\models\query\ActiveQuery;

/**
 * Class ProfileQuery
 *
 * @package thread\modules\user\models\query
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class ProfileQuery extends ActiveQuery
{
    /**
     * @param int $user_id
     * @return $this
     */
    public function user_id(int $user_id)
    {
        /** @var ActiveRecord $modelClass */
        $modelClass = $this->modelClass;
        $this->andWhere($modelClass::tableName() . '.user_id = :user_id', [':user_id' => $user_id]);
        return $this;
    }
}
