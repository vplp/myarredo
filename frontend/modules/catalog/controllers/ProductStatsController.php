<?php

namespace frontend\modules\catalog\controllers;

use Yii;
use yii\filters\{
    VerbFilter, AccessControl
};
//
use frontend\modules\catalog\models\ProductStats;
use frontend\components\BaseController;

/**
 * Class ProductStatsController
 *
 * @package frontend\modules\catalog\controllers
 */
class ProductStatsController extends BaseController
{
    public $label = '';
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
                        'roles' => ['admin', 'factory'],
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
        $model = new ProductStats();

        $params = Yii::$app->request->get() ?? [];

        if (Yii::$app->getUser()->getIdentity()->group->role == 'factory') {
            $params['factory_id'] = Yii::$app->getUser()->getIdentity()->profile->factory_id;
        }

        $start_date = mktime(0, 0, 0, date("m"), date("d")-7, date("Y"));
        $end_date = mktime(23, 59, 0, date("m"), date("d"), date("Y"));


        if (!isset($params['start_date'])) {
            $params['start_date'] = date('d-m-Y', $start_date);
        }

        if (!isset($params['end_date'])) {
            $params['end_date'] = date('d-m-Y', $end_date);
        }

        if (!isset($params['country_id'])) {
            $params['country_id'] = 0;
        }

        if (!isset($params['city_id'])) {
            $params['city_id'] = 0;
        }

        if (!isset($params['factory_id'])) {
            $params['factory_id'] = 0;
        }

        $models = $model->search($params);

        $this->title = Yii::t('app', 'Statistics');

        return $this->render('list', [
            'model' => $model,
            'models' => $models->getModels(),
            'pages' => $models->getPagination(),
            'params' => $params,
        ]);
    }
}