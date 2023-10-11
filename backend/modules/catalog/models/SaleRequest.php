<?php

namespace backend\modules\catalog\models;

use thread\app\model\interfaces\BaseBackendModel;

/**
 * Class SaleRequest
 *
 * @package backend\modules\catalog\models
 */
class SaleRequest extends \common\modules\catalog\models\SaleRequest implements BaseBackendModel
{
    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
        return (new search\SaleRequest())->search($params);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function trash($params)
    {
        return (new search\SaleRequest())->trash($params);
    }
}
