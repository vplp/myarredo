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
    /**
     * @param $product_id
     */
    public static function create($product_id)
    {
        /** @var \frontend\modules\catalog\Catalog $module */
        $module = Yii::$app->getModule('catalog');

        if (!$module->isBot2()) {
            $model = new self();

            $model->setScenario('frontend');

            $model->user_id = Yii::$app->getUser()->id ?? 0;
            $model->ip = Yii::$app->request->userIP;

            /** @var \frontend\modules\catalog\Catalog $module */
            $module = Yii::$app->getModule('catalog');

            $model->is_bot = $module->isBot2();
            $model->http_user_agent = $_SERVER['HTTP_USER_AGENT'];
            $model->city_id = Yii::$app->city->getCityId();
            $model->product_id = $product_id;

            $model->save();
        }
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
