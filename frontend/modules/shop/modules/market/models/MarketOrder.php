<?php

namespace frontend\modules\shop\modules\market\models;

use Yii;
use yii\helpers\{
    Url, ArrayHelper
};
use frontend\modules\location\models\{
    City, Country
};

/**
 * Class MarketOrder
 *
 * @property Country $country
 * @property City $city
 *
 * @package frontend\modules\shop\models
 */
class MarketOrder extends \common\modules\shop\modules\market\models\MarketOrder
{
    /**
     * @return mixed
     */
    public static function findBase()
    {
        return self::find()
            ->orderBy(['created_at' => SORT_DESC])
            ->enabled();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::class, ['id' => 'city_id'])->cache(7200);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::class, ['id' => 'country_id'])->cache(7200);
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function findById($id)
    {
        return self::findBase()
            ->byId($id)
            ->one();
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     * @throws \Throwable
     */
    public function search($params)
    {
        return (new search\MarketOrder())->search($params);
    }
}
