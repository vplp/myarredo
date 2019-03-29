<?php

namespace frontend\modules\location\models;

use yii\helpers\ArrayHelper;

/**
 * Class Region
 *
 * @package frontend\modules\location\models
 */
class Region extends \common\modules\location\models\Region
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return [];
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return [];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [];
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [];
    }

    /**
     * @return mixed
     */
    public static function findBase()
    {
        return parent::findBase()->enabled();
    }

    /**
     * @param string $alias
     * @return mixed
     * @throws \Throwable
     */
    public static function findByAlias($alias)
    {
        $result = self::getDb()->cache(function ($db) use ($alias) {
            return self::findBase()->byAlias($alias)->one();
        });

        return $result;
    }

    /**
     * @param int $id
     * @return mixed
     * @throws \Throwable
     */
    public static function findById($id)
    {
        $result = self::getDb()->cache(function ($db) use ($id) {
            return self::findBase()->byId($id)->one();
        });

        return $result;
    }

    /**
     * Drop down list
     *
     * @param int $country_id
     * @return mixed
     */
    public static function dropDownList($country_id = 0)
    {
        $query = self::findBase();

        if ($country_id) {
            $query->andFilterWhere(['country_id' => $country_id]);
        }

        $data = $query->all();

        return ArrayHelper::map($data, 'id', 'lang.title');
    }
}
