<?php

namespace frontend\modules\catalog\models;

use Yii;
//
use frontend\modules\catalog\Catalog;

/**
 * Class ItalianProductStats
 *
 * @package frontend\modules\catalog\models
 */
class ItalianProductStats extends \common\modules\catalog\models\ItalianProductStats
{
    /**
     * @param $item_id
     */
    public static function create($item_id)
    {
        /** @var $module Catalog */
        $module = Yii::$app->getModule('catalog');

        if (!$module->isBot1() && !$module->isBot2()) {
            $model = new self();

            $model->setScenario('frontend');

            $model->user_id = Yii::$app->getUser()->id ?? 0;
            $model->item_id = $item_id;
            $model->country_id = Yii::$app->city->getCountryId();
            $model->city_id = Yii::$app->city->getCityId();
            $model->ip = Yii::$app->request->userIP;
            $model->http_user_agent = $_SERVER['HTTP_USER_AGENT'];
            $model->is_bot = $module->isBot2();

            $model->save();
        }
    }
}
