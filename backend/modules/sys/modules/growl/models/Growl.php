<?php

namespace backend\modules\sys\modules\growl\models;

use thread\app\model\interfaces\BaseBackendModel;
//
use common\modules\sys\modules\growl\models\Growl as CommonGrowlModel;

/**
 * Class Growl
 *
 * @package backend\modules\sys\modules\growl\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Growl extends CommonGrowlModel implements BaseBackendModel
{

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
        return (new search\Growl())->search($params);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function trash($params)
    {
        return (new search\Growl())->trash($params);
    }
}
