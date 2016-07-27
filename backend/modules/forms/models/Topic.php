<?php

namespace backend\modules\forms\models;
use common\modules\forms\models\Topic as CommonTopicModel;
use thread\models\query\ActiveQuery;
use Yii;
use yii\helpers\ArrayHelper;

class Topic extends CommonTopicModel
{
    /**
     * Find base Topic object for current language active and undeleted
     * @return ActiveQuery
     */
    public static function findBase()
    {
        return parent::findBase()->_lang()->enabled();
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
