<?php

namespace backend\modules\catalog\models;

use thread\app\model\interfaces\BaseBackendModel;
//
use common\modules\catalog\models\Product as CommonProductModel;

/**
 * Class Product
 *
 * @package backend\modules\catalog\models
 * @author Andrii Bondarchuk
 * @copyright (c) 2016, VipDesign
 */
class Product extends CommonProductModel implements BaseBackendModel
{
    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
        return (new search\Product())->search($params);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function trash($params)
    {
        return (new search\Product())->trash($params);
    }
}