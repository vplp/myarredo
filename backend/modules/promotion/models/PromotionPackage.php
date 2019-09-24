<?php

namespace backend\modules\promotion\models;

use common\modules\promotion\models\PromotionPackage as CommonPromotionPackageModel;
//
use thread\app\model\interfaces\BaseBackendModel;

/**
 * Class PromotionPackage
 *
 * @package backend\modules\promotion\models
 */
class PromotionPackage extends CommonPromotionPackageModel implements BaseBackendModel
{
    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
        return (new search\PromotionPackage())->search($params);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function trash($params)
    {
        return (new search\PromotionPackage())->trash($params);
    }
}
