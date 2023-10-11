<?php

namespace frontend\modules\location\controllers;

use Yii;
use yii\web\Response;
use yii\filters\VerbFilter;
use frontend\modules\location\models\City;
use frontend\components\BaseController;

/**
 * Class LocationController
 *
 * @package frontend\modules\location\controllers
 */
class LocationController extends BaseController
{
    public $title = "Location";

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'get-cities' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Get cities
     */
    public function actionGetCities()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->getResponse()->format = Response::FORMAT_JSON;

            $country_id = Yii::$app->getRequest()->post('country_id');

            $cities = City::dropDownList($country_id);

            $options = '';
            $options .= '<option value="">--</option>';
            foreach ($cities as $id => $title) {
                $options .= '<option value="' . $id . '">' . $title . '</option>';
            }

            return ['success' => 1, 'options' => $options];
        }
    }
}
