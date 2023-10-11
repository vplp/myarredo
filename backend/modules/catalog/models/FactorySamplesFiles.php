<?php

namespace backend\modules\catalog\models;

use common\modules\catalog\models\FactorySamplesFiles as CommonFactorySamplesFiles;
use thread\app\model\interfaces\BaseBackendModel;
use yii\helpers\ArrayHelper;
use \yii\data\ActiveDataProvider;

class FactorySamplesFiles extends CommonFactorySamplesFiles implements BaseBackendModel
{
    /**
     * Backend form drop down list
     *
     * @param array $option
     * @return array
     */
    public static function dropDownList(array $option = []): array
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
     * @return ActiveDataProvider
     */
    public function search($params): ActiveDataProvider
    {
        return (new search\FactorySamplesFiles())->search($params);
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     */
    public function trash($params): ActiveDataProvider
    {
        return (new search\FactorySamplesFiles())->trash($params);
    }
}