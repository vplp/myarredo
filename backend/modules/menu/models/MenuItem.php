<?php

namespace backend\modules\menu\models;

use thread\app\model\interfaces\BaseBackendModel;

/**
 * @author Fantamas
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
}
