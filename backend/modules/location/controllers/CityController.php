<?php

namespace backend\modules\location\controllers;

use Yii;
use yii\web\Response;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
//
use backend\modules\location\models\{
    City,
    CityLang,
    search\City as filterCityModel
};
//
use thread\actions\AttributeSwitch;
use thread\actions\EditableAttributeSaveLang;
use thread\app\base\controllers\BackendController;

/**
 * Class CityController
 *
 * @package backend\modules\location\controllers
 */
class CityController extends BackendController
{
    public $model = City::class;
    public $modelLang = CityLang::class;
    public $filterModel = filterCityModel::class;

    public $title = 'City';
    public $name = 'city';

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'AccessControl' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['error'],
                        'roles' => ['?', '@'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                    [
                        'allow' => false,
                    ],
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    public function actions()
    {
        return ArrayHelper::merge(
            parent::actions(),
            [
                'attribute-save' => [
                    'class' => EditableAttributeSaveLang::class,
                    'modelClass' => $this->modelLang,
                    'attribute' => 'title',
                ],
                'show_price' => [
                    'class' => AttributeSwitch::class,
                    'modelClass' => $this->model,
                    'attribute' => 'show_price',
                    'redirect' => $this->defaultAction,
                ],
            ]
        );
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
