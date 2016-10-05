<?php

namespace thread\modules\user\models\query;

use thread\app\base\models\query\ActiveQuery;

/**
 * Class UserQuery
 *
 * @package thread\modules\user\models\query
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class UserQuery extends ActiveQuery
{

    /**
     * @param $username
     * @return $this
     */
    public function username(string $username)
    {
        $modelClass = $this->modelClass;
        $this->andWhere($modelClass::tableName() . '.username = :username', [':username' => $username]);
        return $this;
    }

    /**
     * @param $email
     * @return $this
     */
    public function email(string $email)
    {
        $modelClass = $this->modelClass;
        $this->andWhere($modelClass::tableName() . '.email = :email', [':email' => $email]);
        return $this;
    }

    /**
     * @param $token
     * @return $this
     */
    public function password_reset_token(string $token)
    {
        $modelClass = $this->modelClass;
        $this->andWhere($modelClass::tableName() . '.password_reset_token = :token', [':token' => $token]);
        return $this;
    }

    /**
     * @param array $group_ids
     * @return $this
     */
    public function group_ids(array $group_ids)
    {
        /** @var ActiveRecord $modelClass */
        $modelClass = $this->modelClass;
        $this->andWhere(['in', $modelClass::tableName() . '.group_id', $group_ids]);
        return $this;
    }

}
