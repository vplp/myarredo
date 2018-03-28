<?php

namespace backend\modules\sys\modules\configs\models;

use thread\app\model\interfaces\BaseBackendModel;
//
use common\modules\sys\modules\configs\models\Params as CommonParamsModel;

/**
 * Class Params
 *
 * @package backend\modules\sys\modules\configs\models
 */
class Params extends CommonParamsModel implements BaseBackendModel
{
    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
        return (new search\Params())->search($params);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function trash($params)
    {
        return (new search\Params())->trash($params);
    }
}
