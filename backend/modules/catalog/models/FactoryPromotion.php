<?php

namespace backend\modules\catalog\models;

use thread\app\model\interfaces\BaseBackendModel;
use common\modules\catalog\models\FactoryPromotion as CommonFactoryPromotionModel;

/**
 * Class Product
 *
 * @package backend\modules\catalog\models
 */
class FactoryPromotion extends CommonFactoryPromotionModel implements BaseBackendModel
{
    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
        return (new search\FactoryPromotion())->search($params);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function trash($params)
    {
        return (new search\FactoryPromotion())->trash($params);
    }
}
