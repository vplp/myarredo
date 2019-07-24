<?php

namespace backend\modules\catalog\models;

use yii\helpers\ArrayHelper;
use thread\app\model\interfaces\BaseBackendModel;
use common\modules\catalog\models\Types as CommonTypesModel;

/**
 * Class Types
 *
 * @package backend\modules\catalog\models
 */
class Types extends CommonTypesModel implements BaseBackendModel
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
        return (new search\Types())->search($params);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function trash($params)
    {
        return (new search\Types())->trash($params);
    }
}
