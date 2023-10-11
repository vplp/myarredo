<?php

namespace backend\modules\polls\models;

use thread\app\model\interfaces\BaseBackendModel;
//
use common\modules\polls\models\Vote as CommonVoteModel;

/**
 * Class Vote
 *
 * @package backend\modules\polls\models
 */
class Vote extends CommonVoteModel implements BaseBackendModel
{

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
        return (new search\Vote())->search($params);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function trash($params)
    {
        return (new search\Vote())->trash($params);
    }
}
