<?php

namespace backend\modules\location\models;

use yii\helpers\ArrayHelper;
//
use thread\app\model\interfaces\BaseBackendModel;

/**
 * Class City
 *
 * @package backend\modules\location\models
 */
class City extends \common\modules\location\models\City implements BaseBackendModel
{
    /**
     * @param int $country_id
     * @param array $city_id
     * @return array
     */
    public static function dropDownList($country_id = 0, $city_id = [])
    {
        $query = self::findBase();

        if ($country_id) {
            $query->andFilterWhere(['country_id' => $country_id]);
        }

        if ($city_id) {
            $query->byId($city_id);
        }

        $data = $query->undeleted()->all();

        return ArrayHelper::map($data, 'id', 'lang.title');
    }

    public static function dropDownListWithGroup()
    {
        $query = self::findBase();
        $data = $query->undeleted()->all();

        return ArrayHelper::map($data, 'id', 'lang.title', 'country.lang.title');
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
        return (new search\City())->search($params);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function trash($params)
    {
        return (new search\City())->trash($params);
    }
}
