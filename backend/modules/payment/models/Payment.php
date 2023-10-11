<?php

namespace backend\modules\payment\models;

/**
 * Class Payment
 *
 * @package backend\modules\payment\models
 */
class Payment extends \common\modules\payment\models\Payment
{
    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
        return (new search\Payment())->search($params);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function trash($params)
    {
        return (new search\Payment())->trash($params);
    }
}
