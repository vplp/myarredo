<?php

namespace frontend\modules\shop\controllers;

use Yii;
use yii\filters\{
    VerbFilter, AccessControl
};
use yii\web\ForbiddenHttpException;
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
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'list' => ['get', 'post'],
                    'view' => ['get', 'post'],
                ],
            ],
            'AccessControl' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => [
                            'list',
                            'view'
                        ],
                        'roles' => ['partner'],
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

        $models = $model->search($params);

        $this->title = Yii::t('app', 'Orders');

        $this->breadcrumbs[] = [
            'label' => $this->title,
        ];

        $this->actionSaveAnswer();

        $this->actionSaveItemPrice();

        $this->actionSendAnswer();

        return $this->render('list', [
            'models' => $models->getModels(),
            'pages' => $models->getPagination()
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws ForbiddenHttpException
     */
    public function actionView($id)
    {
        $model = Order::findById($id);

        if (empty($model) || Yii::$app->getUser()->isGuest) {
            throw new ForbiddenHttpException('Access denied');
        }

        $this->title = 'Заявка №' . $model->id;

        $this->breadcrumbs[] = [
            'label' => Yii::t('app', 'Orders'),
            'url' => ['/shop/partner-order/list']
        ];

        $this->breadcrumbs[] = [
            'label' => $this->title,
        ];

        return $this->render('view', [
            'model' => $model
        ]);
    }

    /**
     * Action save answer
     */
    private function actionSaveAnswer()
    {
        if (
            Yii::$app->request->isPost &&
            (Yii::$app->request->post('OrderAnswer'))['order_id'] &&
            Yii::$app->request->post('action-save-answer')
        ) {
            $order_id = (Yii::$app->request->post('OrderAnswer'))['order_id'];

            $modelOrder = Order::findById($order_id);

            if ($modelOrder->isArchive()) {
                // message
                Yii::$app->getSession()->setFlash(
                    'error',
                    'Не успели'
                );
            } else {
                $modelAnswer = OrderAnswer::findByOrderIdUserId($order_id, Yii::$app->getUser()->getId());

                if (empty($modelAnswer)) {
                    $modelAnswer = new OrderAnswer();
                }

                $modelAnswer->setScenario('frontend');
                $modelAnswer->user_id = Yii::$app->getUser()->getId();

                if ($modelAnswer->load(Yii::$app->request->post()) && $modelAnswer->validate()) {
                    $transaction = $modelAnswer::getDb()->beginTransaction();
                    try {
                        $save = $modelAnswer->save();
                        if ($save) {
                            $transaction->commit();
                        } else {
                            $transaction->rollBack();
                        }
                    } catch (Exception $e) {
                        $transaction->rollBack();
                    }
                }
            }
        }
    }

    /**
     * Action save answer
     */
    private function actionSaveItemPrice()
    {
        if (
            Yii::$app->request->isPost &&
            (Yii::$app->request->post('OrderAnswer'))['order_id'] &&
            Yii::$app->request->post('OrderItemPrice') &&
            Yii::$app->request->post('action-save-answer')
        ) {
            $order_id = (Yii::$app->request->post('OrderAnswer'))['order_id'];

            $modelOrder = Order::findById($order_id);

            if ($modelOrder->isArchive()) {
                // message
                Yii::$app->getSession()->setFlash(
                    'error',
                    'Не успели'
                );
            } else {

                $dataOrderItemPrice = Yii::$app->request->post('OrderItemPrice');

                foreach ($dataOrderItemPrice as $product_id => $price) {

                    $modelItemPrice = OrderItemPrice::findByOrderIdUserIdProductId(
                        $order_id,
                        Yii::$app->getUser()->getId(),
                        $product_id
                    );

                    if ($modelItemPrice == null) {
                        $modelItemPrice = new OrderItemPrice();
                    }

                    $modelItemPrice->setScenario('frontend');

                    $modelItemPrice->order_id = $order_id;
                    $modelItemPrice->user_id = Yii::$app->getUser()->getId();
                    $modelItemPrice->product_id = $product_id;
                    $modelItemPrice->price = intval($price);

                    if ($modelItemPrice->load(Yii::$app->request->post()) && $modelItemPrice->validate()) {
                        $transaction = $modelItemPrice::getDb()->beginTransaction();
                        try {
                            $save = $modelItemPrice->save();
                            if ($save) {
                                $transaction->commit();
                            } else {
                                $transaction->rollBack();
                            }
                        } catch (Exception $e) {
                            $transaction->rollBack();
                        }
                    }
                }
            }
        }
    }

    /**
     * Action send answer
     */
    private function actionSendAnswer()
    {
        if (
            Yii::$app->request->isPost &&
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
                            //->setFrom(['info@myarredo.ru' => Yii::$app->user->identity->email])
                            //->setFrom(Yii::$app->params['mailer']['setFrom'])
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
        }
    }
}
