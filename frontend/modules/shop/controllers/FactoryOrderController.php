<?php

namespace frontend\modules\shop\controllers;

use Yii;
use yii\db\Exception;
use yii\db\mssql\PDO;
use yii\helpers\ArrayHelper;
use yii\filters\{
    VerbFilter, AccessControl
};
use yii\web\ForbiddenHttpException;
//
use frontend\components\BaseController;
use frontend\modules\location\models\City;
use frontend\modules\shop\models\{Order, OrderAnswer, OrderItemPrice};
use yii\web\Response;

/**
 * Class FactoryOrderController
 *
 * @package frontend\modules\shop\controllers
 */
class FactoryOrderController extends BaseController
{
    public $title = '';

    public $defaultAction = 'list';

    /**
     * @return array
     * @throws ForbiddenHttpException
     * @throws \Throwable
     */
    public function behaviors()
    {
        if (!Yii::$app->getUser()->isGuest && Yii::$app->user->identity->group->role == 'factory' && !Yii::$app->user->identity->profile->factory_id) {
            throw new ForbiddenHttpException(Yii::t('app', 'Access denied without factory id.'));
        }

        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'list' => ['get'],
                    'list-from-italy' => ['get', 'post'],
                    'pjax-save' => ['get', 'post'],
                    'list-italy' => ['get'],
                    'view' => ['get'],
                ],
            ],
            'AccessControl' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['factory'],
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
        $model = new Order();

        $params = Yii::$app->request->post() ?? [];

        $params['product_type'] = 'product';

        $models = $model->search($params);

        $this->title = Yii::t('app', 'Orders');

        $this->breadcrumbs[] = [
            'label' => $this->title,
        ];

        return $this->render('list', [
            'models' => $models->getModels(),
            'pages' => $models->getPagination()
        ]);
    }

    /**
     * @return string
     * @throws \Exception
     * @throws \Throwable
     */
    public function actionListFromItaly()
    {
        $model = new Order();

        $params = Yii::$app->request->post() ?? [];

        $params['product_type'] = 'product';

        $params['country_id'] = 4;

        if (!isset($params['city_id'])) {
            $params['city_id'] = 0;
        }

        if (isset($params['country_id']) && $params['country_id'] > 0 && $params['city_id'] == 0) {
            $modelCity = City::findAll(['country_id' => $params['country_id']]);
            $params['city_id'] = [];
            if ($modelCity != null) {
                foreach ($modelCity as $city) {
                    $params['city_id'][] = $city['id'];
                }
            }
        }

        $models = $model->search($params);

        $this->title = Yii::t('app', 'Orders');

        $this->breadcrumbs[] = [
            'label' => $this->title,
        ];

        return $this->render('list-from-italy', [
            'models' => $models->getModels(),
            'pages' => $models->getPagination()
        ]);
    }

    /**
     * @return string
     * @throws \Exception
     * @throws \Throwable
     */
    public function actionListItaly()
    {
        $model = new Order();

        $params = Yii::$app->request->post() ?? [];

        $params['product_type'] = 'sale-italy';

        $models = $model->search($params);

        $this->title = Yii::t('app', 'Orders');

        $this->breadcrumbs[] = [
            'label' => $this->title,
        ];

        return $this->render('list', [
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
