<?php

namespace backend\modules\catalog\models;

use yii\helpers\ArrayHelper;
use thread\app\model\interfaces\BaseBackendModel;
use common\modules\catalog\models\Specification as CommonSpecificationModel;

/**
 * Class Specification
 *
 * @package backend\modules\catalog\models
 */
class Specification extends CommonSpecificationModel implements BaseBackendModel
{
    /**
     * Backend form drop down list
     * @return array
     */
    public static function dropDownList()
    {
        return ArrayHelper::map(self::findBase()->undeleted()->all(), 'id', 'lang.title');
    }

    /**
     * @param $parentId
     * @return mixed
     */
    public static function dropDownListParents($parentId)
    {
        return ArrayHelper::map(self::findBase()->andWhere(['parent_id' => $parentId])->undeleted()->all(), 'id', 'lang.title');
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
        return (new search\Specification())->search($params);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function trash($params)
    {
        return (new search\Specification())->trash($params);
    }
}
