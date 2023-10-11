<?php

namespace backend\modules\catalog\models;

use yii\helpers\ArrayHelper;
use thread\app\model\interfaces\BaseBackendModel;
use common\modules\catalog\models\Category as CommonCategoryModel;

/**
 * Class Category
 *
 * @package backend\modules\catalog\models
 */
class Category extends CommonCategoryModel implements BaseBackendModel
{
    public $parent_id = 0;

    /**
     * Backend form drop down list
     *
     * @param array $option
     * @return array
     */
    public static function dropDownList($option = [])
    {
        $query = self::findBase();

        if (isset($option['type_id'])) {
            $query->innerJoinWith(["types"])
                ->andFilterWhere([Types::tableName() . '.id' => $option['type_id']]);
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
        return (new search\Category())->search($params);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function trash($params)
    {
        return (new search\Category())->trash($params);
    }
}
