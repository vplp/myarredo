<?php

namespace backend\modules\news\models;

use Yii;
use yii\helpers\ArrayHelper;
//
use common\modules\news\models\Group as CommonGroupModel;

class Group extends CommonGroupModel
{

    /**
     * Backend form dropdown list
     * @return array
     */
    public static function getDropdownList()
    {
        return ArrayHelper::map(self::findBase()->all(), 'id', 'lang.title');
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
        return (new search\Group())->search($params);
    }
}
