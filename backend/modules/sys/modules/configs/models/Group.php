<?php

namespace backend\modules\sys\modules\configs\models;

use yii\helpers\ArrayHelper;
//
use thread\app\model\interfaces\BaseBackendModel;
//
use common\modules\sys\modules\configs\models\Group as CommonGroupModel;

/**
 * Class Group
 *
 * @package backend\modules\sys\modules\configs\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Group extends CommonGroupModel implements BaseBackendModel
{

    /**
     * Backend form dropdown list
     * @return array
     */
    public static function dropDownList()
    {
        return ArrayHelper::map(self::findBase()->joinWith(['lang'])->undeleted()->all(), 'id', 'lang.title');
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
        return (new search\Group())->search($params);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function trash($params)
    {
        return (new search\Group())->trash($params);
    }

    /**
     * @return mixed
     */
    public function getParamsCount()
    {
        return $this->getParams()->count();
    }
}
