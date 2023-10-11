<?php

namespace backend\modules\sys\modules\logbook\models;

use thread\app\model\interfaces\BaseBackendModel;
use thread\modules\sys\modules\logbook\models\LogbookAuthModel as ParentModel;

/**
 * Class Logbook
 *
 * @package backend\modules\sys\modules\logbook\models
 */
class LogbookAuth extends ParentModel implements BaseBackendModel
{
    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
        return (new search\LogbookAuth())->search($params);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function trash($params)
    {
        return (new search\LogbookAuth())->trash($params);
    }
}
