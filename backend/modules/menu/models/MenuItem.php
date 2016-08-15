<?php

namespace backend\modules\menu\models;

use thread\app\model\interfaces\BaseBackendModel;

/**
 * Class MenuItem
 *
 * @package backend\modules\menu\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class MenuItem extends \common\modules\menu\models\MenuItem implements BaseBackendModel
{
    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
        return (new search\MenuItem())->search($params);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function trash($params)
    {
        return (new search\MenuItem())->trash($params);
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function findById($id)
    {
        return self::find()->byID($id)->one();
    }
}
