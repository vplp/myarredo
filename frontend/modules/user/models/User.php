<?php

namespace frontend\modules\user\models;

/**
 * Class User
 *
 * @package frontend\modules\user\models
 */
class User extends \common\modules\user\models\User
{
    /**
     * @param integer $city_id
     * @return mixed
     */
    public static function getPartners($city_id = 0)
    {
        $groups = Group::getIdsByRole('partner');

        $query = self::findBase()
            ->group_ids($groups)
            ->published();

        if ($city_id) {
            $query->andFilterWhere([Profile::tableName() . '.city_id' => $city_id]);
        }

        return $query->all();
    }
}
