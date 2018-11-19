<?php

namespace frontend\modules\catalog\models;

use yii\helpers\ArrayHelper;

/**
 * Class Collection
 *
 * @package frontend\modules\catalog\models
 */
class Collection extends \common\modules\catalog\models\Collection
{
    /**
     * @return mixed
     */
    public static function findBase()
    {
        return parent::findBase()->enabled()->asArray();
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function findById($id)
    {
        return self::findBase()->byId($id)->one();
    }

    /**
     * Search
     *
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
        return (new search\Collection())->search($params);
    }

    /**
     * @param array $params
     * @return mixed
     */
    public static function getWithProduct($params = [])
    {
        return self::findBase()
            ->all();
    }

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
}