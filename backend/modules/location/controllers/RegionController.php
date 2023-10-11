<?php

namespace backend\modules\location\controllers;

use Yii;
use yii\web\Response;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
//
use backend\modules\location\models\{
    Region,
    RegionLang,
    search\Region as filterRegionModel
};
//
use thread\actions\EditableAttributeSaveLang;
use thread\app\base\controllers\BackendController;

/**
 * Class RegionController
 *
 * @package backend\modules\location\controllers
 */
class RegionController extends BackendController
{
    public $model = Region::class;
    public $modelLang = RegionLang::class;
    public $filterModel = filterRegionModel::class;

    public $title = 'Region';
    public $name = 'region';

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
                ]
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

            $cities = Region::dropDownList($country_id);

            $options = '';
            $options .= '<option value="">--</option>';
            foreach ($cities as $id => $title) {
                $options .= '<option value="' . $id . '">' . $title . '</option>';
            }

            return ['success' => 1, 'options' => $options];
        }
    }
}
