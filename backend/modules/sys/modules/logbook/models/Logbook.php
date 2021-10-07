<?php

namespace backend\modules\sys\modules\logbook\models;

use backend\modules\user\models\User;
use thread\app\model\interfaces\BaseBackendModel;
use yii\helpers\ArrayHelper;

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

    /**
     * @return array
     */
    public static function dropDownListUsers()
    {
        $query = self::find()
            ->indexBy('user_id')
            ->select('user_id, count(user_id) as count')
            ->groupBy('user_id')
            ->andWhere('user_id > 0')
            ->asArray()
            ->all();

        $ids = [];

        foreach ($query as $item) {
            $ids[] = $item['user_id'];
        }

        if ($ids) {
            return ArrayHelper::map(
                User::findBase()->andWhere(['IN', User::tableName() . '.id', $ids])->all(),
                'id',
                'username'
            );
        } else {
            return [];
        }
    }
}
