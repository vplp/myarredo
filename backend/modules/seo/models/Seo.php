<?php

namespace backend\modules\seo\models;

use common\modules\seo\models\Seo as CommonSeoModel;
use thread\app\model\interfaces\BaseBackendModel;

/**
 * Class Seo
 *
 * @package backend\modules\seo\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Seo extends CommonSeoModel implements BaseBackendModel
{
    /**
     * Find base Seo object for current language active and undeleted
     *
     * @return mixed
     */
    public static function findBase()
    {
        return parent::findBase()->undeleted();
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
        return (new search\Seo())->search($params);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function trash($params)
    {
        return (new search\Seo())->trash($params);
    }

}
