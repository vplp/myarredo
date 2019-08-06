<?php

namespace frontend\modules\shop\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Exception;
use yii\db\mssql\PDO;
use yii\db\Transaction;
use yii\filters\AccessControl;
use yii\web\Response;
//
use frontend\components\BaseController;
use frontend\modules\location\models\City;
use frontend\modules\payment\models\Payment;
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
                            'list-italy',
                            'list-italy-answers',
                            'pay-italy-delivery',
                            'pjax-save'
                        ],
                        'roles' => ['partner'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'list-italy',
                            'list-italy-answers',
                            'pay-italy-delivery',
                            'pjax-save'
                        ],
                        'roles' => ['logistician'],
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
        $model = new Order();

        $params = Yii::$app->request->get() ?? [];

        /**
         * add city_id
         */

        if (!isset($params['city_id'])) {
            $params['city_id'] = 0;
        }

        if (Yii::$app->user->identity->profile->country_id != 4 && isset($params['city_id']) && $params['city_id'] == 0 && Yii::$app->user->identity->profile->country_id) {
            unset($params['city_id']);
            $modelCity = City::findAll(['country_id' => Yii::$app->user->identity->profile->country_id]);

            if ($modelCity != null) {
                foreach ($modelCity as $city) {
                    $params['city_id'][] = $city['id'];
                }
            }
        }

        if (!isset($params['factory_id'])) {
            $params['factory_id'] = 0;
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

        if (!in_array(Yii::$app->user->identity->group->role, ['logistician']) &&
            Yii::$app->user->identity->profile->country_id != 4 &&
            isset($params['city_id']) && $params['city_id'] == 0
        ) {
            unset($params['city_id']);
            $modelCity = City::findAll(['country_id' => Yii::$app->user->identity->profile->country_id]);

            if ($modelCity != null) {
                foreach ($modelCity as $city) {
                    $params['city_id'][] = $city['id'];
                }
            }
        }

        if (!isset($params['factory_id'])) {
            $params['factory_id'] = 0;
        }

        $params['product_type'] = 'sale-italy';

        $models = $model->search($params);

        $this->title = Yii::t('app', 'Orders');

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
    public function actionPjaxSave()
    {
        if (Yii::$app->request->isPost &&
            (Yii::$app->request->post('OrderAnswer'))['order_id'] &&
            Yii::$app->request->post('OrderItemPrice') &&
            Yii::$app->request->post('action-save-answer')
        ) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            $response = ['success' => 1];

            $order_id = (Yii::$app->request->post('OrderAnswer'))['order_id'];

            /** @var  $modelOrder  Order */
            $modelOrder = Order::findById($order_id);

            if ($modelOrder->isArchive()) {
                // show message
                Yii::$app->getSession()->setFlash(
                    'error',
                    'Не успели'
                );
            } else {

                /**
                 * save OrderItemPrice
                 */

                $dataOrderItemPrice = Yii::$app->request->post('OrderItemPrice');

                foreach ($dataOrderItemPrice as $product_id => $price) {
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
                    $modelOrderItemPrice->price = intval($price);

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

                            if ($modelOrder->product_type == 'product') {
                                $viewMail = '/../mail/answer_order_user_letter';
                            } else {
                                $viewMail = '/../mail/answer_order_italy_user_letter';
                            }

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
                                ->setSubject('Ответ за заказ № ' . $modelOrder['id'])
                                ->send();

                            // message
                            Yii::$app->getSession()->setFlash(
                                'success',
                                'Отправлено'
                            );
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
    public function actionListItalyAnswers()
    {
        $model = new OrderItem();

        $params['user_id'] = Yii::$app->user->identity->id;
        $params['product_type'] = 'sale-italy';

        $models = $model->search($params);

        $this->title = Yii::t('app', 'Оплатить заявки на доставку');

        $this->breadcrumbs[] = [
            'label' => $this->title,
        ];

        return $this->render('list-italy/answers', [
            'dataProvider' => $models,
        ]);
    }

    /**
     * @param $id
     * @return mixed
     * @throws \yii\base\InvalidConfigException
     */
    public function actionPayItalyDelivery($id)
    {
        $model = OrderItem::findByID($id);

        /** @var $model OrderItem */
        if ($model == null) {
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }

        $modelPayment = new Payment();
        $modelPayment->setScenario('frontend');

        $modelPayment->user_id = Yii::$app->user->id;
        $modelPayment->type = 'italian_item_delivery';
        $modelPayment->amount = $model->getDeliveryAmount();
        $modelPayment->currency = 'RUB';
        $modelPayment->items_ids = [$model->id];

        /** @var Transaction $transaction */
        $transaction = $modelPayment::getDb()->beginTransaction();
        try {
            $modelPayment->payment_status = Payment::PAYMENT_STATUS_PENDING;

            $save = $modelPayment->save();

            if ($save) {
                $transaction->commit();

                /** @var \robokassa\Merchant $merchant */
                $merchant = Yii::$app->get('robokassa');

                return $merchant->payment(
                    $modelPayment->amount,
                    $modelPayment->id,
                    Yii::t('app', 'Оплата заявки на доставку'),
                    null,
                    Yii::$app->user->identity->email,
                    substr(Yii::$app->language, 0, 2)
                );
            } else {
                $transaction->rollBack();
            }
        } catch (Exception $e) {
            $transaction->rollBack();
        }
    }
}
