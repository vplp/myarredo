<?php

namespace backend\modules\user\models;

use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
//
use thread\app\model\interfaces\BaseBackendModel;

/**
 * Class User
 *
 * @package admin\modules\user\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class User extends \thread\modules\user\models\User implements BaseBackendModel
{
    /**
     * Backend form dropdown list
     * @return array
     */
    public static function dropDownList()
    {
        return ArrayHelper::map(self::findBase()->enabled()->all(), 'id', 'email');
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        return (new search\User)->search($params);
    }

    /**
     *
     * @param array $params
     * @return ActiveDataProvider
     */
    public function trash($params)
    {
        return (new search\User)->trash($params);
    }
}
