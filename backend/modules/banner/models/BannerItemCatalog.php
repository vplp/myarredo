<?php

namespace backend\modules\banner\models;

use thread\app\model\interfaces\BaseBackendModel;
use common\modules\banner\models\BannerItemCatalog as CommonBannerItemCatalog;

/**
 * Class BannerItemCatalog
 *
 * @package backend\modules\banner\models
 */
class BannerItemCatalog extends CommonBannerItemCatalog implements BaseBackendModel
{
    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
        return (new search\BannerItemCatalog())->search($params);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function trash($params)
    {
        return (new search\BannerItemCatalog())->trash($params);
    }
}
