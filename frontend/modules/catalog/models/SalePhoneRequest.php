<?php

namespace frontend\modules\catalog\models;

use Yii;
use frontend\modules\user\components\UserIpComponent;

/**
 * Class SalePhoneRequest
 *
 * @package frontend\modules\catalog\models
 */
class SalePhoneRequest extends \common\modules\catalog\models\SalePhoneRequest
{
    /**
     * @param $sale_item_id
     */
    public static function create($sale_item_id)
    {
        /** @var \frontend\modules\catalog\Catalog $module */
        $module = Yii::$app->getModule('catalog');

        if (!$module->isBot1() && !$module->isBot2()) {
            $model = new self();

            $model->setScenario('frontend');

            $model->user_id = Yii::$app->getUser()->id ?? 0;
            $model->sale_item_id = $sale_item_id;
            $model->country_id = Yii::$app->city->getCountryId();
            $model->city_id = Yii::$app->city->getCityId();
            $model->ip = (new UserIpComponent())->ip;//Yii::$app->request->userIP;
            $model->http_user_agent = $_SERVER['HTTP_USER_AGENT'];
            $model->is_bot = $module->isBot2();

            $model->save();
        }
    }
}
