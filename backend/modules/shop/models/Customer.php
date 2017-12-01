<?php

namespace backend\modules\shop\models;

use thread\app\model\interfaces\BaseBackendModel;
use common\modules\shop\models\Customer as CommonCustomerModel;

/**
 * Class Customer
 *
 * @package backend\modules\shop\models
 */
class Customer extends CommonCustomerModel implements BaseBackendModel
{
 
    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
        return (new search\Customer())->search($params);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function trash($params)
    {
        return (new search\Customer())->trash($params);
    }
}