<?php

namespace backend\modules\sys\modules\logbook\models;

use thread\app\model\interfaces\BaseBackendModel;

/**
 * Class Logbook
 *
 * @package backend\modules\sys\modules\logbook\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Logbook extends \common\modules\sys\modules\logbook\models\Logbook implements BaseBackendModel
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
}
