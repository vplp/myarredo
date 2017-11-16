<?php

namespace backend\modules\seo\modules\directlink\models;

use thread\app\model\interfaces\BaseBackendModel;

/**
 * Class Directlink
 *
 * @package backend\modules\seo\modules\directlink\models
 */
class Directlink extends \common\modules\seo\modules\directlink\models\Directlink implements BaseBackendModel
{
    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
        return (new search\Directlink())->search($params);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function trash($params)
    {
        return (new search\Directlink())->trash($params);
    }
}
