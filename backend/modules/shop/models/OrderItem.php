<?php

namespace backend\modules\shop\models;

use common\modules\shop\models\OrderItem as CommonOrderItemModel;

use thread\app\model\interfaces\BaseBackendModel;
/**
 * Class OrderItem
 * @package backend\modules\shop\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @author Alla Kuzmenko
 * @copyright (c) 2016, VipDesign
 */
class OrderItem extends CommonOrderItemModel implements BaseBackendModel
{ 
    /**
 * @param $params
 * @return \yii\data\ActiveDataProvider
 */
    public function search($params)
    {
        return (new search\OrderItem())->search($params);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function trash($params)
    {
        return (new search\OrderItem())->trash($params);
    }

    /**
     * Получаем search модели (Похожие товары) || (Запчасти) И (ПРИНАДЛЕЖНОСТИ)
     * @return \yii\data\ActiveDataProvider
     */
    public function items($orderlId)
    {
        return (new search\OrderItem())->getSearchModelsOrderItems($orderlId);
    }
    
}