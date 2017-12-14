<?php

namespace frontend\modules\catalog\controllers;

use Yii;
use yii\filters\{
    VerbFilter, AccessControl
};
use yii\helpers\ArrayHelper;
use frontend\modules\catalog\models\{
    ProductStats, Factory
};
use frontend\components\BaseController;

/**
 * Class ProductStatsController
 *
 * @package frontend\modules\catalog\controllers
 */
class ProductStatsController extends BaseController
{
    public $label = "Stats";
    public $title = "Stats";

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

    public function actionList()
    {
        $model = new ProductStats();

        $params = Yii::$app->request->get();

        if (Yii::$app->getUser()->getIdentity()->group->role == 'factory') {
            $params['factory_id'] = Yii::$app->getUser()->getIdentity()->profile->factory_id;
        }

        $models = $model->search(ArrayHelper::merge(Yii::$app->request->queryParams, $params));

        $this->title = 'Статистика';

        return $this->render('list', [
            'model' => $model,
            'models' => $models->getModels(),
            'pages' => $models->getPagination(),
        ]);
    }
}