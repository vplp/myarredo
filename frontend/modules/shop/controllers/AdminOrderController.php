<?php

namespace frontend\modules\shop\controllers;

use Yii;
use yii\filters\{
    VerbFilter, AccessControl
};
//
use frontend\components\BaseController;
use frontend\modules\location\models\City;
use frontend\modules\shop\models\Order;

/**
 * Class AdminOrderController
 *
 * @package frontend\modules\shop\controllers
 */
class AdminOrderController extends BaseController
{
    public $title = '';

    public $defaultAction = 'list';

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'list' => ['get', 'post'],
                ],
            ],
            'AccessControl' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => [
                            'list',
                        ],
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
     * @return string
     */
    public function actionList()
    {
        $model = new Order();

        $params = Yii::$app->request->get() ?? [];

        if (isset($params['country_id']) && $params['country_id'] > 0 && $params['city_id'] == 0) {
            $modelCity = City::findAll(['country_id' => $params['country_id']]);
            $params['city_id'] = [];
            if ($modelCity != null) {
                foreach ($modelCity as $city) {
                    $params['city_id'][] = $city['id'];
                }
            }
        }

        if (!isset($params['country_id'])) {
            $params['country_id'] = 0;
        }

        if (!isset($params['city_id'])) {
            $params['city_id'] = 0;
        }

        $models = $model->search($params);

        $this->title = Yii::t('app', 'Orders');

        $this->breadcrumbs[] = [
            'label' => $this->title,
        ];

        return $this->render('list', [
            'model' => $model,
            'models' => $models,
            'params' => $params,
        ]);
    }
}
