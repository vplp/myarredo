<?php

namespace backend\modules\catalog\models;

use thread\app\model\interfaces\BaseBackendModel;
use common\modules\catalog\models\ItalianProduct as CommonItalianProductModel;

/**
 * Class ItalianProduct
 *
 * @package backend\modules\catalog\models
 */
class ItalianProduct extends CommonItalianProductModel implements BaseBackendModel
{
    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
        return (new search\ItalianProduct())->search($params);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function trash($params)
    {
        return (new search\ItalianProduct())->trash($params);
    }
}
