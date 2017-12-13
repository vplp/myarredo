<?php

namespace frontend\modules\catalog\models;

use Yii;

/**
 * Class ProductStats
 *
 * @package frontend\modules\catalog\models
 */
class ProductStats extends \common\modules\catalog\models\ProductStats
{
    public static function create($product_id)
    {
        $model = new self();

        $model->setScenario('frontend');

        $model->user_id = Yii::$app->getUser()->id ?? 0;
        $model->city_id = Yii::$app->city->getCityId();
        $model->product_id = $product_id;

        $model->save();
    }

    /**
     * @param $params
     * @return mixed
     */
    public function search($params)
    {
        return (new search\ProductStats())->search($params);
    }
}
