<?php

namespace frontend\modules\shop\controllers;

use Yii;
use yii\filters\{
    VerbFilter, AccessControl
};
use yii\db\Exception;
use yii\db\mssql\PDO;
use yii\db\Transaction;
use yii\web\ForbiddenHttpException;
use yii\web\Response;
use yii\web\NotFoundHttpException;
use frontend\components\BaseController;
use frontend\modules\location\models\City;
use frontend\modules\shop\models\Order;
use frontend\modules\shop\models\OrderAnswer;
use frontend\modules\shop\models\OrderComment;
use frontend\modules\shop\models\OrderItemPrice;

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
                    'manager' => ['get', 'post'],
                    'list' => ['get', 'post'],
                    'list-italy' => ['get', 'post'],
                    'pjax-save-order-answer' => ['get', 'post'],
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
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionManager($id)
    {
        $model = Order::findById($id);

        /** @var $model Order */

        if ($model == null) {
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        } elseif (Yii::$app->user->identity->profile->getPossibilityToAnswer($model) == false) {
            throw new ForbiddenHttpException('Access denied');
        }

        if (Yii::$app->getRequest()->post('order_status')) {
            $model->scenario = 'order_status';
            $model->order_status = Yii::$app->getRequest()->post('order_status');

            $model->save();
        }

        if (Yii::$app->getRequest()->post('content')) {
            $modelComment = new OrderComment();

            $modelComment->scenario = 'frontend';
            $modelComment->order_id = $model->id;
            $modelComment->user_id = Yii::$app->user->id;
            $modelComment->type = Yii::$app->getRequest()->post('type');
            $modelComment->reminder_time = Yii::$app->getRequest()->post('reminder_time');
            $modelComment->content = Yii::$app->getRequest()->post('content');

            $modelComment->save();
        }

        $this->title = Yii::t('shop', 'Работа с заказом');

        $this->breadcrumbs[] = [
            'label' => $this->title,
        ];

        return $this->render('manager/_form', [
            'modelOrder' => $model
        ]);
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

        if (!isset($params['order_status'])) {
            $params['order_status'] = null;
        }

        if (!isset($params['full_name'])) {
            $params['full_name'] = null;
        }

        if (!isset($params['phone'])) {
            $params['phone'] = null;
        }

        if (!isset($params['email'])) {
            $params['email'] = null;
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

        if (!isset($params['order_status'])) {
            $params['order_status'] = null;
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

    /**
     * @return array
     */
    public function actionPjaxSaveOrderAnswer()
    {
        if (Yii::$app->request->isPost &&
            (Yii::$app->request->post('OrderAnswer'))['order_id'] &&
            //Yii::$app->request->post('OrderItemPrice') &&
            Yii::$app->request->post('action-save-answer')
        ) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            $response = ['success' => 1];

            $order_id = (Yii::$app->request->post('OrderAnswer'))['order_id'];

            /** @var  $modelOrder  Order */
            $modelOrder = Order::findById($order_id);

            if ($modelOrder->isArchive()) {
                // show message
                Yii::$app->getSession()->setFlash('error', 'Не успели');
            } else {
                /**
                 * save Order
                 */
                if ((Yii::$app->request->post('Order'))['admin_comment']) {
                    $modelOrder->scenario = 'admin_comment';
                    $modelOrder->admin_comment = (Yii::$app->request->post('Order'))['admin_comment'];
                    $modelOrder->save();
                }

                /**
                 * save OrderItemPrice
                 */
                $dataOrderItemPrice = Yii::$app->request->post('OrderItemPrice');

                if ($dataOrderItemPrice) {
                    foreach ($dataOrderItemPrice as $product_id => $modelPrice) {
                        $modelOrderItemPrice = OrderItemPrice::findByOrderIdUserIdProductId(
                            $modelOrder->id,
                            Yii::$app->getUser()->getId(),
                            $product_id
                        );

                        if ($modelOrderItemPrice == null) {
                            $modelOrderItemPrice = new OrderItemPrice();
                        }

                        $modelOrderItemPrice->setScenario('frontend');

                        $modelOrderItemPrice->order_id = $modelOrder->id;
                        $modelOrderItemPrice->user_id = Yii::$app->getUser()->getId();
                        $modelOrderItemPrice->product_id = $product_id;
                        $modelOrderItemPrice->price = isset($modelPrice['price']) ? intval($modelPrice['price']) : 0;
                        $modelOrderItemPrice->currency = $modelPrice['currency'];
                        $modelOrderItemPrice->out_of_production = isset($modelPrice['out_of_production']) ? $modelPrice['out_of_production'] : '0';

                        if ($modelOrderItemPrice->load(Yii::$app->request->post()) && $modelOrderItemPrice->validate()) {
                            /** @var PDO $transaction */
                            $transaction = $modelOrderItemPrice::getDb()->beginTransaction();
                            try {
                                $save = $modelOrderItemPrice->save();

                                if ($save) {
                                    $transaction->commit();
                                } else {
                                    $transaction->rollBack();
                                }

                                if ($modelOrderItemPrice->out_of_production && $save) {
                                    foreach ($modelOrder->items as $item) {
                                        if ($item->product['id'] == $modelOrderItemPrice->product_id) {
                                            $item->product->removed = '1';
                                            $item->product->setScenario('removed');
                                            $item->product->save();
                                        }
                                    }
                                }
                            } catch (Exception $e) {
                                $transaction->rollBack();
                            }
                        } else {
                            $response['success'] = 0;
                            $response['OrderItemPrice'][$product_id] = $modelOrderItemPrice->getFirstErrors();
                        }
                    }

                    if (isset($response['OrderItemPrice'])) {
                        return $response;
                    }
                }

                /**
                 * save OrderAnswer
                 */
                $modelOrderAnswer = OrderAnswer::findByOrderIdUserId($order_id, Yii::$app->getUser()->getId());

                if (empty($modelOrderAnswer)) {
                    $modelOrderAnswer = new OrderAnswer();
                }

                $modelOrderAnswer->setScenario('frontend');
                $modelOrderAnswer->user_id = Yii::$app->getUser()->getId();
                $modelOrderAnswer->answer_time = time();

                if ($modelOrderAnswer->load(Yii::$app->request->post()) && $modelOrderAnswer->validate()) {
                    /** @var PDO $transaction */
                    $transaction = $modelOrderAnswer::getDb()->beginTransaction();
                    try {
                        $save = $modelOrderAnswer->save();

                        if ($save) {
                            $transaction->commit();

                            // begin send
                            if ($modelOrder->product_type == 'product') {
                                $viewMail = '/../mail/answer_order_user_letter';
                            } else {
                                $viewMail = '/../mail/answer_order_italy_user_letter';
                            }

                            $currentLanguage = Yii::$app->language;
                            Yii::$app->language = $modelOrder->lang;

                            // send user letter
                            Yii::$app
                                ->mailer
                                ->compose(
                                    $viewMail,
                                    [
                                        'modelOrder' => $modelOrder,
                                        'modelAnswer' => $modelOrderAnswer,
                                    ]
                                )
                                ->setTo($modelOrder->customer['email'])
                                ->setSubject(Yii::t('app', 'Ответ за заказ') . ' № ' . $modelOrder['id'])
                                ->send();

                            Yii::$app->language = $currentLanguage;

                            // message
                            Yii::$app->getSession()->setFlash(
                                'success',
                                Yii::t('app', 'Отправлено')
                            );
                            // end send
                        } else {
                            $transaction->rollBack();
                        }
                    } catch (Exception $e) {
                        $transaction->rollBack();
                    }
                } else {
                    $response['success'] = 0;
                    $response['OrderAnswer'] = $modelOrderAnswer->getFirstErrors();
                }

                return $response;
            }
        }
    }
}
