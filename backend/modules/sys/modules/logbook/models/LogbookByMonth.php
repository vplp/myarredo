<?php

namespace backend\modules\sys\modules\logbook\models;

use backend\modules\user\models\User;
use thread\app\model\interfaces\BaseBackendModel;
use yii\helpers\ArrayHelper;

/**
 * Class LogbookByMonth
 *
 * @package backend\modules\sys\modules\logbook\models
 */
class LogbookByMonth extends \thread\modules\sys\modules\logbook\models\LogbookByMonth implements BaseBackendModel
{
    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
        return (new search\LogbookByMonth())->search($params);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function trash($params)
    {
        return (new search\LogbookByMonth())->trash($params);
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
                'profile.fullName'
            );
        } else {
            return [];
        }
    }

    public static function dropDownListActionMethod()
    {
        $query = self::find()
            ->indexBy('action_method')
            ->select('action_method, count(action_method) as count')
            ->groupBy('action_method')
            ->asArray()
            ->all();

        if ($query) {
            return ArrayHelper::map(
                $query,
                'action_method',
                'action_method'
            );
        } else {
            return [];
        }
    }
}
