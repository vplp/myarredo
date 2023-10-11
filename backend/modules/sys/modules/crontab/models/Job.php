<?php

namespace backend\modules\sys\modules\crontab\models;

use thread\app\model\interfaces\BaseBackendModel;
//
use common\modules\sys\modules\crontab\models\Job as CommonJobModel;

/**
 * Class Job
 *
 * @package backend\modules\sys\modules\crontab\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Job extends CommonJobModel implements BaseBackendModel
{

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
        return (new search\Job())->search($params);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function trash($params)
    {
        return (new search\Job())->trash($params);
    }
}
