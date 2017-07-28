<?php

namespace backend\modules\catalog\models;

use yii\helpers\ArrayHelper;
use thread\app\model\interfaces\BaseBackendModel;
use common\modules\catalog\models\FactoryFile as CommonFactoryFileModel;

/**
 * Class FactoryFile
 *
 * @package backend\modules\catalog\models
 */
class FactoryFile extends CommonFactoryFileModel implements BaseBackendModel
{
    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
        return (new search\FactoryFile())->search($params);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function trash($params)
    {
        return (new search\FactoryFile())->trash($params);
    }
}
