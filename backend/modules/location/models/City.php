<?php

namespace backend\modules\location\models;

/**
 * @author Roman Gonchar <roman.gonchar92@gmail.com>
 */

class City extends \common\modules\location\models\City
{
    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
        return (new search\City())->search($params);
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
