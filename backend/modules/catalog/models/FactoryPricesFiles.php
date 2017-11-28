<?php

namespace backend\modules\catalog\models;

use yii\helpers\ArrayHelper;
use thread\app\model\interfaces\BaseBackendModel;
use common\modules\catalog\models\FactoryPricesFiles as CommonFactoryPricesFiles;

/**
 * Class FactoryPricesFiles
 *
 * @package backend\modules\catalog\models
 */
class FactoryPricesFiles extends CommonFactoryPricesFiles implements BaseBackendModel
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
            $query->andFilterWhere([
                'factory_id' => $option['factory_id']
            ]);
        }

        if (isset($option['file_type'])) {
            $query->andFilterWhere([
                'file_type' => $option['file_type']
            ]);
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
        return (new search\FactoryPricesFiles())->search($params);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function trash($params)
    {
        return (new search\FactoryPricesFiles())->trash($params);
    }
}
