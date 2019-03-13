<?php

namespace frontend\modules\location\controllers;

use Yii;
use yii\web\Response;
use yii\filters\VerbFilter;
//
use frontend\modules\location\models\Currency;
//
use frontend\components\BaseController;

/**
 * Class CurrencyController
 *
 * @package frontend\modules\location\controllers
 */
class CurrencyController extends BaseController
{
    public $title = "Currency";

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'change-currency' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Get cities
     */
    public function actionChange()
    {
        if (Yii::$app->request->isAjax && $currency = Yii::$app->getRequest()->post('currency')) {
            Yii::$app->getResponse()->format = Response::FORMAT_JSON;

            if (array_key_exists($currency, Currency::getMapCode2Course())) {
                Yii::$app->session->set('currency', $currency);
                return ['success' => 1];
            }

            return ['success' => 0];
        }
    }
}
