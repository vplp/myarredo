<?php

namespace backend\modules\rules\models;

use common\modules\rules\models\Rules as CommonRulesModel;
//
use thread\modules\seo\behaviors\SeoBehavior;
use thread\app\model\interfaces\BaseBackendModel;

/**
 * Class Rules
 *
 * @package backend\modules\articles\models
 */
class Rules extends CommonRulesModel implements BaseBackendModel
{
    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
        return (new search\Rules())->search($params);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function trash($params)
    {
        return (new search\Rules())->trash($params);
    }
}
