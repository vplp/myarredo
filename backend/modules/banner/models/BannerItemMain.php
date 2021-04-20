<?php

namespace backend\modules\banner\models;

use thread\app\model\interfaces\BaseBackendModel;
use common\modules\banner\models\BannerItemMain as CommonBannerItemMain;

/**
 * Class BannerItemMain
 *
 * @package backend\modules\banner\models
 */
class BannerItemMain extends CommonBannerItemMain implements BaseBackendModel
{
    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
        return (new search\BannerItemMain())->search($params);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function trash($params)
    {
        return (new search\BannerItemMain())->trash($params);
    }
}
