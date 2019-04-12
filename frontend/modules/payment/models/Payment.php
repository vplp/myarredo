<?php

namespace frontend\modules\payment\models;

/**
 * Class Payment
 *
 * @package frontend\modules\payment\models
 */
class Payment extends \common\modules\payment\models\Payment
{
    /**
     * @return mixed
     */
    public static function findBase()
    {
        return parent::findBase()->enabled();
    }

    /**
     * @param $params
     * @return mixed|\yii\data\ActiveDataProvider
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public function search($params)
    {
        return (new search\Payment())->search($params);
    }
}
