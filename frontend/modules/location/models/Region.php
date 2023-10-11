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
        return parent::findBase()->asArray()->enabled();
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
        }, 60 * 60);

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
        }, 60 * 60);

        return $result;
    }

    /**
     * @param int $country_id
     * @return array|mixed
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public static function dropDownList($country_id = 0)
    {
        $data = self::getDb()->cache(function ($db) use ($country_id) {
            $query = self::findBase();

            if ($country_id) {
                $query->andFilterWhere(['country_id' => $country_id]);
            }

            return $query->all();
        }, 60 * 60);

        return ArrayHelper::map($data, 'id', 'lang.title');
    }
}
