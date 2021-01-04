<?php

namespace frontend\modules\location\controllers;

use Yii;
use yii\web\Response;
use yii\filters\VerbFilter;
use frontend\modules\location\models\Currency;
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
                    'change' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Change currency
     */
    public function actionChange()
    {
        $response = ['success' => 0];

        if (Yii::$app->request->isAjax && $currency = Yii::$app->getRequest()->post('currency')) {
            Yii::$app->getResponse()->format = Response::FORMAT_JSON;

            /**
             * Set currency
             */
            if (array_key_exists($currency, Currency::getMapCode2Course())) {
                Yii::$app->session->set('currency', $currency);
                $response['success'] = 1;
            }

            Yii::$app->catalogFilter->parserUrl(Yii::$app->getRequest()->post('filter'));

            $keys = Yii::$app->catalogFilter->keys;
            $params = Yii::$app->catalogFilter->params;

            if (isset($params[$keys['price']])) {
                $params[$keys['price']] = [];
                $response['link'] = Yii::$app->catalogFilter->createUrl($params);
            }
        }

        return $response;
    }
}
