<?php

namespace frontend\modules\forms\controllers;

use Yii;
use yii\web\Response;
use yii\filters\VerbFilter;
//
use frontend\components\BaseController;
use frontend\modules\forms\models\ClickOnBecomePartner;
use frontend\modules\user\components\UserIpComponent;

/**
 * Class ClickOnBecomePartnerController
 *
 * @package frontend\modules\forms\controllers
 */
class ClickOnBecomePartnerController extends BaseController
{
    public $title = '';

    public $defaultAction = 'index';

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'index' => ['post']
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    public function actionIndex()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->getResponse()->format = Response::FORMAT_JSON;

            $model = new ClickOnBecomePartner(['scenario' => 'frontend']);

            $model->country_id = Yii::$app->city->getCountryId();
            $model->city_id = Yii::$app->city->getCityId();
            $model->ip = (new UserIpComponent())->ip;//Yii::$app->request->userIP;
            $model->http_user_agent = $_SERVER['HTTP_USER_AGENT'];

            $save = $model->save();

            return ['success' => $save];
        }
    }
}
