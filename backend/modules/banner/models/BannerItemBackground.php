<?php

namespace backend\modules\banner\models;

use thread\app\model\interfaces\BaseBackendModel;
use common\modules\banner\models\BannerItemBackground as CommonBannerItemBackground;

/**
 * Class BannerItemBackground
 *
 * @package backend\modules\banner\models
 */
class BannerItemBackground extends CommonBannerItemBackground implements BaseBackendModel
{
    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
        return (new search\BannerItemBackground())->search($params);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function trash($params)
    {
        return (new search\BannerItemBackground())->trash($params);
    }
}
