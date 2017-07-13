<?php

namespace backend\modules\sys\modules\translation\models;

use yii\helpers\ArrayHelper;
use thread\app\model\interfaces\BaseBackendModel;
use common\modules\sys\modules\translation\models\Source as CommonSource;

/**
 * Class Source
 *
 * @author Andrew Kontseba - Skinwalker <andjey.skinwalker@gmail.com>
 * @package backend\modules\sys\modules\translation\models
 */
class Source extends CommonSource implements BaseBackendModel
{
    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
        return (new search\Source())->search($params);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function trash($params)
    {
        return (new search\Source())->trash($params);
    }

    /**
     * @param $from
     * @param $to
     * @return array
     */
    public static function listFromTo($from, $to)
    {
        return ArrayHelper::map(self::findBase()->joinWith(['message'])->undeleted()->all(), $from, $to);
    }
}
