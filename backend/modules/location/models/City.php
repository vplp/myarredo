<?php

namespace backend\modules\location\models;

use thread\app\model\interfaces\BaseBackendModel;

/**
 * Class City
 *
 * @package backend\modules\location\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class City extends \common\modules\location\models\City implements BaseBackendModel
{
    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
        return (new search\City())->search($params);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function trash($params)
    {
        return (new search\Currency())->trash($params);
    }
}
