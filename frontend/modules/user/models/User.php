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
     * findBase
     *
     * @return mixed
     */
    public static function findBase()
    {
        return parent::findBase()->enabled();
    }

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

        $query->orderBy(Profile::tableName() . '.partner_in_city DESC');

        return $query->all();
    }

    /**
     * @param $city_id
     * @return mixed
     */
    public static function getPartner($city_id)
    {
        $groups = Group::getIdsByRole('partner');

        $query = self::findBase()
            ->group_ids($groups)
            ->published();

        if ($city_id) {
            $query->andWhere([
                Profile::tableName() . '.city_id' => $city_id,
                Profile::tableName() . '.partner_in_city' => '1',
            ]);
        }

        return $query->one();
    }

}
