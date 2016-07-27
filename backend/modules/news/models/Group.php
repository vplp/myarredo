<?php

namespace backend\modules\news\models;

use common\modules\news\models\Group as CommonGroupModel;
use thread\models\query\ActiveQuery;
use Yii;
use yii\helpers\ArrayHelper;

class Group extends CommonGroupModel
{
    /**
     * Find base Page object for current language active and undeleted
     * @return ActiveQuery
     */
    public static function findBase()
    {
        return parent::findBase()->_lang()->enabled();
    }

    /**
     * Find ONE Page object in array by its alias
     * @param string $alias
     * @return array
     */
    public static function findByAlias($alias)
    {
        return self::findBase()->alias($alias)->asArray()->one();
    }

    /**
     * Backend form dropdown list
     * @return array
     */
    public static function getDropdownList()
    {
        return ArrayHelper::map(self::findBase()->all(), 'id', 'lang.title');
    }
}
