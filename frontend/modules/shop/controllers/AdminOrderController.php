<?php

namespace frontend\modules\shop\controllers;

use Yii;
use yii\filters\{
    VerbFilter, AccessControl
};
use frontend\components\BaseController;
use frontend\modules\location\models\City;
use frontend\modules\shop\models\Order;
use yii\db\Exception;
use yii\db\Transaction;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

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
                    'update' => ['post'],
                    'list' => ['get', 'post'],
                    'list-italy' => ['get', 'post'],
                ],
            ],
            'AccessControl' => [
                'class' => AccessControl::class,
                'rules' => [
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
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = Order::findById($id);

        /** @var $model Order */

        if ($model == null) {
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }

        $model->scenario = 'admin_comment';

        if ($model->load(Yii::$app->getRequest()->post())) {
            /** @var Transaction $transaction */
            $transaction = $model::getDb()->beginTransaction();
            try {
                $save = $model->save();

                if ($save) {
                    $transaction->commit();
                } else {
                    $transaction->rollBack();
                }
            } catch (Exception $e) {
                $transaction->rollBack();
            }
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * @return string
     * @throws \Throwable
     */
    public function actionList()
    {
        $model = new Order();

        $params = Yii::$app->request->get() ?? [];

        $start_date = mktime(0, 0, 0, 1, 1, date("Y"));
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

        if (!isset($params['lang'])) {
            $params['lang'] = null;
        }

        $params['product_type'] = 'product';

        $models = $model->search($params);

        $this->title = Yii::t('app', 'Orders');

        $this->breadcrumbs[] = [
            'label' => $this->title,
        ];

        return $this->render('list/list', [
            'models' => $models,
            'model' => $model,
            'params' => $params,
        ]);
    }

    /**
     * @return string
     * @throws \Throwable
     */
    public function actionListItaly()
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

        if (!isset($params['factory_id'])) {
            $params['factory_id'] = 0;
        }

        if (!isset($params['lang'])) {
            $params['lang'] = null;
        }

        $params['product_type'] = 'sale-italy';

        $models = $model->search($params);

        $this->title = Yii::t('app', 'Orders');

        $this->breadcrumbs[] = [
            'label' => $this->title,
        ];

        return $this->render('list-italy/list', [
            'model' => $model,
            'models' => $models,
            'params' => $params,
        ]);
    }
}
