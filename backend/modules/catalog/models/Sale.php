<?php

namespace backend\modules\catalog\models;

use thread\app\model\interfaces\BaseBackendModel;
use common\modules\catalog\models\Sale as CommonSaleModel;

/**
 * Class Sale
 *
 * @package backend\modules\catalog\models
 */
class Sale extends CommonSaleModel implements BaseBackendModel
{
    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
        return (new search\Sale())->search($params);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function trash($params)
    {
        return (new search\Sale())->trash($params);
    }
}
