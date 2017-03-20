<?php

namespace backend\modules\user\models;

use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
//
use thread\app\model\interfaces\BaseBackendModel;

/**
 * Class Group
 *
 * @package admin\modules\user\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Group extends \common\modules\user\models\Group implements BaseBackendModel
{

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        return (new search\Group)->search($params);
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function trash($params)
    {
        return (new search\Group)->trash($params);
    }

    /**
     * @return array
     */
    public static function dropDownList()
    {
        return ArrayHelper::map(self::findBase()->joinWith(['lang'])->all(), 'id', 'lang.title');
    }

    /**
     * @return mixed
     */
    public function getUsersCount()
    {
        return $this->getUsers()->count();
    }

    /**
     * updateUsersRoleInGroup
     */
    public function updateUsersRoleInGroup()
    {
        if ($this->getUsersCount() > 0) {
            $oldGroupRole = $this->getOldAttribute('role');
            if ($oldGroupRole !== $this->role) {
                $list = $this->getUsers();
                foreach ($list as $user) {
                    $user->save(false);
                }
            }
        }
    }

    /**
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
    }
}
