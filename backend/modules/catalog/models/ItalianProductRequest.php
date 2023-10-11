<?php

namespace backend\modules\catalog\models;

use thread\app\model\interfaces\BaseBackendModel;

/**
 * Class ItalianProductRequest
 *
 * @package backend\modules\catalog\models
 */
class ItalianProductRequest extends \common\modules\catalog\models\ItalianProductRequest implements BaseBackendModel
{
    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
        return (new search\ItalianProductRequest())->search($params);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function trash($params)
    {
        return (new search\ItalianProductRequest())->trash($params);
    }
}
