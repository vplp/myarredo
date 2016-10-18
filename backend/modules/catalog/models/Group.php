<?php

namespace backend\modules\catalog\models;

use yii\helpers\ArrayHelper;
//
use thread\app\model\interfaces\BaseBackendModel;
//
use common\modules\catalog\models\Group as CommonGroupModel;

/**
 * Class Group
 *
 * @package backend\modules\catalog\models
 * @author Andrii Bondarchuk
 * @copyright (c) 2016, VipDesign
 */
class Group extends CommonGroupModel implements BaseBackendModel
{
    /**
     * Backend form dropdown list
     * @return array
     */
    public static function getDropdownList()
    {
        return ArrayHelper::map(self::findBase()->joinWith(['lang'])->all(), 'id', 'lang.title');
    }

    /**
     * Backend form dropdown list hierarchy
     * @return array
     */
    public static function getDropdownListHierarchy()
    {
        $options = [];

        $parents = self::findBase()->innerJoinWith(['lang'])->where("parent_id=0")->all();

        if ($parents != null) {
            foreach ($parents as $p) {
                $options[$p->id] = $p->lang->title;
                $children = self::findBase()->innerJoinWith(['lang'])->where("parent_id=:parent_id", [":parent_id" => $p->id])->all();
                if ($children != null) {
                    foreach ($children as $child) {
                        $options[$child->id] = ' - ' . $child->lang->title;
                    }
                }
            }
        }
        return $options;
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
}