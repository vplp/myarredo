<?php

namespace backend\modules\seo\models;

use thread\app\model\interfaces\BaseBackendModel;
//
use common\modules\seo\models\Redirects as CommonRedirectsModel;

/**
 * Class Redirects
 *
 * @package backend\modules\seo\models
 */
class Redirects extends CommonRedirectsModel implements BaseBackendModel
{
    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
        return (new search\Redirects())->search($params);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function trash($params)
    {
        return (new search\Redirects())->trash($params);
    }
}
