<?php

namespace frontend\modules\shop\models;

/**
 * Class OrderAnswer
 *
 * @package frontend\modules\shop\models
 */
class OrderAnswer extends \common\modules\shop\models\OrderAnswer
{
    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     * @throws \Throwable
     */
    public function search($params)
    {
        return (new search\OrderAnswer())->search($params);
    }
}
