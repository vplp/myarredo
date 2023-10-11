<?php

namespace backend\modules\menu\models;

use thread\app\model\interfaces\BaseBackendModel;

/**
 * Class Menu
 *
 * @package backend\modules\menu\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Menu extends \common\modules\menu\models\Menu implements BaseBackendModel
{
    public $title;

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
        return (new search\Menu())->search($params);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function trash($params)
    {
        return (new search\Menu())->trash($params);
    }
}
