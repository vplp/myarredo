<?php

namespace backend\modules\forms\models;

use yii\helpers\ArrayHelper;
use backend\modules\location\models\{
    Country, City
};

/**
 * Class ClickOnBecomePartner
 *
 * @package backend\modules\forms\models
 */
class ClickOnBecomePartner extends \common\modules\forms\models\ClickOnBecomePartner
{
    /**
     * @return array
     */
    public static function dropDownListCountries()
    {
        $data = self::findBase()->all();
        $country_ids = ArrayHelper::map($data, 'country_id', 'country_id');
        return Country::dropDownList($country_ids);
    }

    /**
     * @return array
     */
    public static function dropDownListCities()
    {
        $data = self::findBase()->all();
        $city_ids = ArrayHelper::map($data, 'city_id', 'city_id');
        return City::dropDownList(0, $city_ids);
    }

    /**
     * @param $params
     * @return mixed
     */
    public function search($params)
    {
        return (new search\ClickOnBecomePartner())->search($params);
    }

    /**
     * @param $params
     * @return mixed
     */
    public function trash($params)
    {
        return (new search\ClickOnBecomePartner())->trash($params);
    }
}
