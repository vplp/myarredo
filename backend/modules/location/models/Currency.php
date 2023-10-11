<?php

namespace backend\modules\location\models;

/**
 * Class Currency
 *
 * @package backend\modules\location\models
 */
class Currency extends \common\modules\location\models\Currency
{
    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
        return (new search\Currency())->search($params);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function trash($params)
    {
        return (new search\Currency())->trash($params);
    }
}
