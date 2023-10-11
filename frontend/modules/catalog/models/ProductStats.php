<?php

namespace frontend\modules\catalog\models;

use Yii;
//
use frontend\modules\catalog\Catalog;
use frontend\modules\user\components\UserIpComponent;

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
        /** @var $module Catalog */
        $module = Yii::$app->getModule('catalog');

        if (!$module->isBot1() && !$module->isBot2()) {
            $model = new self();

            $model->setScenario('frontend');

            $model->user_id = Yii::$app->getUser()->id ?? 0;
            $model->ip = (new UserIpComponent())->ip;//Yii::$app->request->userIP;
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
