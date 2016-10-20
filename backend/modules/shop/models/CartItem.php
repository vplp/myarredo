<?php

namespace backend\modules\shop\models;
use common\modules\shop\models\CartItem as CommonCartItemModel;

use thread\app\model\interfaces\BaseBackendModel;


/**
 * Class CartItem
 * @package backend\modules\shop\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @author Alla Kuzmenko
 * @copyright (c) 2016, VipDesign
 */
class CartItem extends CommonCartItemModel implements BaseBackendModel
{

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
        return (new search\CartItem())->search($params);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function trash($params)
    {
        return (new search\CartItem())->trash($params);
    }
}