<?php


namespace backend\modules\shop\models;

use common\modules\shop\models\DeliveryMethods as CommonDeliveryMethodsModel;

use thread\app\model\interfaces\BaseBackendModel;
/**
 * Class DeliveryMethods
 *
 * @package backend\modules\shop\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class DeliveryMethods extends CommonDeliveryMethodsModel implements BaseBackendModel
{
    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
        return (new search\DeliveryMethods())->search($params);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function trash($params)
    {
        return (new search\DeliveryMethods())->trash($params);
    }
}
