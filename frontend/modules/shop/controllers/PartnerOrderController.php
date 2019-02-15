<?php

namespace frontend\modules\shop\controllers;

use Yii;
use yii\db\mssql\PDO;
use yii\filters\AccessControl;
//
use frontend\components\BaseController;
use frontend\modules\location\models\City;
use frontend\modules\shop\models\{
    Order, OrderAnswer, OrderItemPrice
};

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
                        'roles' => ['partner', 'logistician'],
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

        $params = Yii::$app->request->post() ?? [];

        /**
         * add city_id
         */
        $modelCity = City::findAll(['country_id' => Yii::$app->user->identity->profile->country_id]);

        if ($modelCity != null) {
            foreach ($modelCity as $city) {
                $params['city_id'][] = $city['id'];
            }
        }


        $params['product_type'] = 'product';

        $models = $model->search($params);

        $this->title = Yii::t('app', 'Orders');

        $this->breadcrumbs[] = [
            'label' => $this->title,
        ];

        return $this->render('list/list', [
            'models' => $models->getModels(),
            'pages' => $models->getPagination()
        ]);
    }

    /**
     * @return string
     * @throws \Throwable
     */
    public function actionListItaly()
    {
        $model = new Order();

        $params = Yii::$app->request->post() ?? [];

        /**
         * add city_id
         */
        $modelCity = City::findAll(['country_id' => Yii::$app->user->identity->profile->country_id]);

        if ($modelCity != null) {
            foreach ($modelCity as $city) {
                $params['city_id'][] = $city['id'];
            }
        }

        $params['product_type'] = 'sale-italy';

        $models = $model->search($params);

        $this->title = Yii::t('app', 'Orders');

        $this->breadcrumbs[] = [
            'label' => $this->title,
        ];

        return $this->render('list-italy/list', [
            'models' => $models->getModels(),
            'pages' => $models->getPagination()
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
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

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

                if ($modelOrderAnswer->load(Yii::$app->request->post()) && $modelOrderAnswer->validate()) {
                    /** @var PDO $transaction */
                    $transaction = $modelOrderAnswer::getDb()->beginTransaction();
                    try {
                        $save = $modelOrderAnswer->save();
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
                    $response['OrderAnswer'] = $modelOrderAnswer->getFirstErrors();
                }

                return $response;
            }
        }
    }

    /**
     * Send answer
     */
    public function actionSendAnswer()
    {
        if (Yii::$app->request->isPost &&
            (Yii::$app->request->post('OrderAnswer'))['order_id'] &&
            Yii::$app->request->post('action-send-answer')
        ) {
            $order_id = (Yii::$app->request->post('OrderAnswer'))['order_id'];

            $modelOrder = Order::findById($order_id);
            $modelAnswer = OrderAnswer::findByOrderIdUserId($order_id, Yii::$app->getUser()->getId());

            if (empty($modelAnswer)) {
                $modelAnswer = new OrderAnswer();
            }

            $modelAnswer->setScenario('frontend');
            $modelAnswer->user_id = Yii::$app->getUser()->getId();
            $modelAnswer->answer_time = time();

            if ($modelAnswer->load(Yii::$app->request->post()) && $modelAnswer->validate()) {
                /** @var PDO $transaction */
                $transaction = $modelAnswer::getDb()->beginTransaction();
                try {
                    $save = $modelAnswer->save();
                    if ($save) {
                        $transaction->commit();

                        // send user letter
                        Yii::$app
                            ->mailer
                            ->compose(
                                '/../mail/answer_order_user_letter',
                                [
                                    'modelOrder' => $modelOrder,
                                    'modelAnswer' => $modelAnswer,
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
            }

            return $this->redirect($modelOrder->getPartnerOrderOnListUrl());
        }
    }
}
