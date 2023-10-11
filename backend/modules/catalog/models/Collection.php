<?php

namespace backend\modules\catalog\models;

use yii\helpers\ArrayHelper;
use thread\app\model\interfaces\BaseBackendModel;
use common\modules\catalog\models\Collection as CommonCollectionModel;

/**
 * Class Collection
 *
 * @package backend\modules\catalog\models
 */
class Collection extends CommonCollectionModel implements BaseBackendModel
{
    /**
     * Backend form drop down list
     *
     * @param array $option
     * @return array
     */
    public static function dropDownList($option = [])
    {
        $query = self::findBase();

        if (isset($option['factory_id'])) {
            $query->andFilterWhere(['factory_id' => $option['factory_id']]);
        }

        $data = $query->undeleted()->all();

        return ArrayHelper::map($data, 'id', 'title');
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
        return (new search\Collection())->search($params);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function trash($params)
    {
        return (new search\Collection())->trash($params);
    }
}
