<?php

namespace backend\modules\banner\models;

use thread\app\model\interfaces\BaseBackendModel;
use common\modules\banner\models\BannerItem as CommonBannerItemModel;

/**
 * Class BannerItem
 *
 * @package backend\modules\banner\models
 */
class BannerItem extends CommonBannerItemModel implements BaseBackendModel
{
    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
        return (new search\BannerItem())->search($params);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function trash($params)
    {
        return (new search\BannerItem())->trash($params);
    }
}
