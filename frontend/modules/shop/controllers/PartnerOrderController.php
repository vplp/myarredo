<?php

namespace frontend\modules\shop\controllers;

use Yii;
use yii\db\Exception;
use yii\db\mssql\PDO;
use yii\web\Response;
use yii\filters\AccessControl;
use frontend\components\BaseController;
use frontend\modules\shop\models\{Order, OrderAnswer, OrderItem, OrderItemPrice};

/**
 * Class PartnerOrderController
 *
 * @package frontend\modules\shop\controllers
 */
class PartnerOrderController extends BaseController
{
    public $title = '';

    public $defaultAction = 'list';

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
                        'actions' => [
                            'list',
                            'delivery-italian-orders',
                            'pjax-save-order-answer'
                        ],
                        'roles' => ['partner'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'list-italy',
                            'delivery-italian-orders',
                            'pjax-save-order-answer'
                        ],
                        'roles' => ['logistician', 'partner'],
                    ],
                    [
                        'allow' => false,
                    ],
                ],
            ],
        ];
    }

    /**
     * @param \yii\base\Action $action
     * @return bool|Response
     * @throws \yii\base\ExitException
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        if (!Yii::$app->getUser()->isGuest && in_array(Yii::$app->user->identity->group->role, ['admin'])) {
            $href = str_replace(
                'partner',
                'admin',
                Yii::$app->request->url
            );

            return $this->redirect($href, 301);
        }

        return parent::beforeAction($action);
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

        /**
         * add city_id
         */
        if (!isset($params['city_id'])) {
            $params['city_id'] = 0;
        }

        if (!isset($params['country_id'])) {
            $params['country_id'] = 0;
        }

        if (!isset($params['factory_id'])) {
            $params['factory_id'] = 0;
        }

        $params['product_type'] = 'sale-italy';

        $models = $model->search($params);

        $this->title = Yii::t('app', 'Orders italy');

        $this->breadcrumbs[] = [
            'label' => $this->title,
        ];

        return $this->render('list-italy/list', [
            'models' => $models,
            'model' => $model,
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

                            ///*
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
                            //*/
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

    /**
     * @return string
     * @throws \Throwable
     */
    public function actionDeliveryItalianOrders()
    {
        $model = new OrderItem();

        $params['user_id'] = Yii::$app->user->identity->id;
        $params['product_type'] = 'sale-italy';

        $models = $model->search($params);

        $this->title = Yii::t('app', 'Оплатить заявки на доставку');

        $this->breadcrumbs[] = [
            'label' => $this->title,
        ];

        return $this->render('list-italy/delivery_italian_orders', [
            'dataProvider' => $models,
        ]);
    }
}
