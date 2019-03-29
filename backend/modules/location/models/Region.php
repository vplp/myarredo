<?php

namespace backend\modules\location\models;

use yii\helpers\ArrayHelper;
//
use thread\app\model\interfaces\BaseBackendModel;


/**
 * Class Region
 *
 * @package backend\modules\location\models
 */
class Region extends \common\modules\location\models\Region implements BaseBackendModel
{
    /**
     * @param int $country_id
     * @return array
     */
    public static function dropDownList($country_id = 0)
    {
        $query = self::findBase();

        if ($country_id) {
            $query->andFilterWhere(['country_id' => $country_id]);
        }

        $data = $query->undeleted()->all();

        return ArrayHelper::map($data, 'id', 'lang.title');
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
        return (new search\Region())->search($params);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function trash($params)
    {
        return (new search\Region())->trash($params);
    }
}
