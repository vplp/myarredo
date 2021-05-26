<?php

namespace frontend\modules\user\models;

/**
 * Class User
 *
 * @package frontend\modules\user\models
 */
class User extends \common\modules\user\models\User
{
    public $answerCount;

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
     * @param $id
     * @return mixed
     */
    public static function findById($id)
    {
        return self::findBase()->byID($id)->one();
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
            ->enabled();

        if ($city_id) {
            $query->andFilterWhere([Profile::tableName() . '.city_id' => $city_id]);
        }

        $query->andFilterWhere([Profile::tableName() . '.show_contacts' => '1']);

        $query->orderBy([
            Profile::tableName() . '.partner_in_city' => SORT_DESC,
            ProfileLang::tableName() . '.name_company' => SORT_ASC
        ]);

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
            ->enabled();

        if ($city_id) {
            $query->andWhere([
                Profile::tableName() . '.city_id' => $city_id,
                Profile::tableName() . '.partner_in_city' => '1',
            ]);
        }

        return $query->one();
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public function searchOrderAnswerStats($params)
    {
        return (new search\User())->searchOrderAnswerStats($params);
    }
}
