<?php

namespace backend\modules\configs\models;

use yii\helpers\ArrayHelper;
//
use thread\app\model\interfaces\BaseBackendModel;
//
use common\modules\configs\models\Group as CommonGroupModel;

/**
 * Class Group
 *
 * @package backend\modules\configs\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Group extends CommonGroupModel implements BaseBackendModel
{

    /**
     * Backend form dropdown list
     * @return array
     */
    public static function getDropdownList()
    {
        return ArrayHelper::map(self::findBase()->enabled()->joinWith(['lang'])->all(), 'id', 'lang.title');
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
