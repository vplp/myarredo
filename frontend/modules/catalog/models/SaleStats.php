<?php

namespace frontend\modules\catalog\models;

use Yii;
//
use frontend\modules\catalog\Catalog;
use frontend\modules\user\components\UserIpComponent;

/**
 * Class SaleStats
 *
 * @package frontend\modules\catalog\models
 */
class SaleStats extends \common\modules\catalog\models\SaleStats
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
            $model->product_id = $product_id;
            $model->country_id = Yii::$app->city->getCountryId();
            $model->city_id = Yii::$app->city->getCityId();
            $model->ip = (new UserIpComponent())->ip;//Yii::$app->request->userIP;
            $model->http_user_agent = $_SERVER['HTTP_USER_AGENT'];
            $model->is_bot = $module->isBot2();

            $model->save();
        }
    }

    /**
     * @param $params
     * @return mixed|\yii\data\ActiveDataProvider
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public function search($params)
    {
        return (new search\SaleStats())->search($params);
    }
}
