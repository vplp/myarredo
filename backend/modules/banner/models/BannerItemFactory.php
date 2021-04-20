<?php

namespace backend\modules\banner\models;

use thread\app\model\interfaces\BaseBackendModel;
use common\modules\banner\models\BannerItemFactory as CommonBannerItemFactory;

/**
 * Class BannerItemFactory
 *
 * @package backend\modules\banner\models
 */
class BannerItemFactory extends CommonBannerItemFactory implements BaseBackendModel
{
    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
        return (new search\BannerItemFactory())->search($params);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function trash($params)
    {
        return (new search\BannerItemFactory())->trash($params);
    }
}
