<?php

namespace backend\modules\location\models;

/**
 * @author Roman Gonchar <roman.gonchar92@gmail.com>
 */

class Country extends \common\modules\location\models\Country
{
    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
        return (new search\Country())->search($params);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function trash($params)
    {
        return (new search\Currency())->trash($params);
    }

    public function getDropDownList(){

    }
}
