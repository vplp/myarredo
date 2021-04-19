<?php

namespace frontend\modules\catalog\controllers;

use Yii;
use yii\filters\{
    VerbFilter, AccessControl
};
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use frontend\modules\catalog\models\{
    Sale, SaleStats, SaleStatsDays
};
use frontend\components\BaseController;

/**
 * Class SaleStatsController
 *
 * @package frontend\modules\catalog\controllers
 */
class SaleStatsController extends BaseController
{
    public $label = '';
    public $title = '';

    public $defaultAction = 'list';

    /**
     * @return array
     * @throws ForbiddenHttpException
     * @throws \Throwable
     */
    public function behaviors()
    {
        if (!Yii::$app->getUser()->isGuest &&
            Yii::$app->user->identity->group->role == 'factory' &&
            !Yii::$app->user->identity->profile->factory_id) {
            throw new ForbiddenHttpException(
                Yii::t('app', 'Access denied without factory id.')
            );
        }

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
                        'roles' => ['admin', 'settlementCenter', 'factory'],
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
     * @throws \Exception
     * @throws \Throwable
     */
    public function actionList()
    {
        $model = new SaleStatsDays();

        $params = Yii::$app->request->get() ?? [];

        if (!Yii::$app->getUser()->isGuest && Yii::$app->user->identity->group->role == 'factory') {
            $params['factory_id'] = Yii::$app->user->identity->profile->factory_id;
        }

        $start_date = mktime(0, 0, 0, date("m"), date("d") - 30, date("Y"));
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

        if (!isset($params['type'])) {
            $params['type'] = null;
        }

        $params['action'] = 'list';

        $models = $model->search($params);

        $this->title = Yii::t('app', 'Sale statistics');

        return $this->render('list', [
            'model' => $model,
            'models' => $models->getModels(),
            'pages' => $models->getPagination(),
            'params' => $params,
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $model = Sale::findByID($id);

        if ($model == null) {
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }

        $modelSaleStatsDays = new SaleStatsDays();

        $params = Yii::$app->request->get() ?? [];

        $params['product_id'] = $model['id'];

        $start_date = mktime(0, 0, 0, date("m"), date("d") - 30, date("Y"));
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

        if (!isset($params['type'])) {
            $params['type'] = null;
        }

        $params['action'] = 'view';

        $stats = $modelSaleStatsDays->search($params);

        $this->title = Yii::t('app', 'Sale statistics');

        return $this->render('view', [
            'model' => $model,
            'params' => $params,
            'modelSaleStatsDays' => $modelSaleStatsDays,
            'modelsStats' => $stats->getModels(),
        ]);
    }
}
