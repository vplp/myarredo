<?php

namespace backend\modules\catalog\models;

use yii\helpers\ArrayHelper;
use thread\app\model\interfaces\BaseBackendModel;
use common\modules\catalog\models\SubTypes as CommonSubTypesModel;

/**
 * Class SubTypes
 *
 * @package backend\modules\catalog\models
 */
class SubTypes extends CommonSubTypesModel implements BaseBackendModel
{
    /**
     * @param array $option
     * @return array
     */
    public static function dropDownList($option = [])
    {
        $query = self::findBase();

        if (isset($option['parent_id'])) {
            $query->andFilterWhere([
                'parent_id' => $option['parent_id']
            ]);
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
        return (new search\SubTypes())->search($params);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function trash($params)
    {
        return (new search\SubTypes())->trash($params);
    }
}
