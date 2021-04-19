<?php

namespace frontend\modules\shop\controllers;

use Yii;
use yii\filters\{
    VerbFilter, AccessControl
};
//
use frontend\modules\user\models\User;
use frontend\modules\shop\models\{
    OrderAnswer, OrderItemPrice
};
use frontend\components\BaseController;

/**
 * Class OrderAnswerStatsController
 *
 * @package frontend\modules\shop\controllers
 */
class OrderAnswerStatsController extends BaseController
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
                    'view' => ['get'],
                ],
            ],
            'AccessControl' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin', 'settlementCenter'],
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
     * @throws \Throwable
     */
    public function actionList()
    {
        $model = new User();

        $params = Yii::$app->request->get() ?? [];

        $params['group_id'] = 4;

        if (!isset($params['country_id'])) {
            $params['country_id'] = 0;
        }

        if (!isset($params['city_id'])) {
            $params['city_id'] = 0;
        }

        $models = $model->searchOrderAnswerStats($params);

        $this->title = Yii::t('app', 'Answers statistics');

        $this->breadcrumbs[] = [
            'label' => $this->title,
        ];

        return $this->render('list', [
            'models' => $models,
            'model' => $model,
            'params' => $params,
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws \Throwable
     */
    public function actionView($id)
    {
        $model = new OrderAnswer();

        $params = Yii::$app->request->get() ?? [];

        $params['user_id'] = $id;

        $models = $model->search($params);

        $this->title = Yii::t('app', 'Answers statistics');

        $this->breadcrumbs[] = [
            'label' => $this->title,
        ];

        return $this->render('view', [
            'models' => $models,
            'model' => $model,
            'params' => $params,
        ]);
    }
}
