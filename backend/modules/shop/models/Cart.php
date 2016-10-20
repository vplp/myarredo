<?php

namespace backend\modules\shop\models;

use common\modules\shop\models\Cart as CommonCartModel;

use thread\app\model\interfaces\BaseBackendModel;

/**
 * Class Cart
 * @package backend\modules\shop\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @author Alla Kuzmenko
 * @copyright (c) 2016, VipDesign
 */
class Cart extends CommonCartModel implements BaseBackendModel
{

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
        return (new search\Cart())->search($params);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function trash($params)
    {
        return (new search\Cart())->trash($params);
    }
}