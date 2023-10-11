<?php

namespace backend\modules\catalog\models;

use thread\app\model\interfaces\BaseBackendModel;
use common\modules\catalog\models\FactorySubdivision as CommonFactorySubdivision;

/**
 * Class FactorySubdivision
 *
 * @package backend\modules\catalog\models
 */
class FactorySubdivision extends CommonFactorySubdivision implements BaseBackendModel
{
    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
        return (new search\FactorySubdivision())->search($params);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function trash($params)
    {
        return (new search\FactorySubdivision())->trash($params);
    }
}
