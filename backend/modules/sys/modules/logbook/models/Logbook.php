<?php

namespace backend\modules\sys\modules\logbook\models;

use thread\app\model\interfaces\BaseBackendModel;

/**
 * Class Logbook
 *
 * @package backend\modules\sys\modules\logbook\models
 */
class Logbook extends \thread\modules\sys\modules\logbook\models\Logbook implements BaseBackendModel
{
    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
        return (new search\Logbook())->search($params);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function trash($params)
    {
        return (new search\Logbook())->trash($params);
    }

    /**
     * @param $model_id
     * @param $model_name
     * @return mixed
     */
    public static function getCountItems($model_id, $model_name)
    {
        $query = Logbook::find()->undeleted();
        $query
            ->andFilterWhere([Logbook::tableName() . '.model_id' => $model_id])
            ->andFilterWhere([Logbook::tableName() . '.model_name' => $model_name]);

        return $query->count();
    }

    public static function getLastItem($model_id, $model_name)
    {
        $query = Logbook::find()->undeleted()->orderBy(['created_at' => SORT_DESC]);
        $query
            ->andFilterWhere([Logbook::tableName() . '.model_id' => $model_id])
            ->andFilterWhere([Logbook::tableName() . '.model_name' => $model_name]);

        return $query->one();
    }
}
