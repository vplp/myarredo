<?php

namespace backend\modules\user\models;

use yii\data\ActiveDataProvider;
use thread\app\model\interfaces\BaseBackendModel;

/**
 * Class User
 *
 * @package backend\modules\user\models
 */
class User extends \common\modules\user\models\User implements BaseBackendModel
{
    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        return (new search\User())->search($params);
    }

    /**
     *
     * @param array $params
     * @return ActiveDataProvider
     */
    public function trash($params)
    {
        return (new search\User())->trash($params);
    }
}
