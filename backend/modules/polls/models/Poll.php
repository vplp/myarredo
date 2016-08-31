<?php

namespace backend\modules\polls\models;

use yii\helpers\ArrayHelper;
//
use thread\app\model\interfaces\BaseBackendModel;
//
use common\modules\polls\models\Poll as CommonPollModel;

/**
 * Class Poll
 *
 * @package backend\modules\polls\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Poll extends CommonPollModel implements BaseBackendModel
{

    /**
     * Backend form dropdown list
     * @return array
     */
    public static function getDropdownList()
    {
        return ArrayHelper::map(self::findBase()->joinWith(['lang'])->all(), 'id', 'lang.title');
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
        return (new search\Poll())->search($params);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function trash($params)
    {
        return (new search\Poll())->trash($params);
    }

    /**
     * @return mixed
     */
    public function getVotesCount()
    {
        return $this->getVotes()->count();
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function findById($id)
    {
        return self::find()->byID($id)->one();
    }
}
