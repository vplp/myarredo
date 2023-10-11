<?php

namespace backend\modules\catalog\models;

use yii\helpers\ArrayHelper;
use common\modules\catalog\models\Colors as CommonColorsModel;
use thread\app\model\interfaces\BaseBackendModel;

/**
 * Class Colors
 *
 * @package backend\modules\catalog\models
 */
class Colors extends CommonColorsModel implements BaseBackendModel
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
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
        return (new search\Colors())->search($params);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function trash($params)
    {
        return (new search\Colors())->trash($params);
    }
}
