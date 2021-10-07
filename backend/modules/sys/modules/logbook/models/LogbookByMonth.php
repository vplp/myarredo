<?php

namespace backend\modules\sys\modules\logbook\models;

use thread\app\model\interfaces\BaseBackendModel;

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
}
