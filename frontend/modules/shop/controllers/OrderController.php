<?php

namespace frontend\modules\shop\controllers;

use frontend\modules\shop\models\OrderItem;
use Yii;
use yii\helpers\Url;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;
use frontend\components\BaseController;
use frontend\modules\shop\models\Order;
use frontend\modules\shop\models\search\Order as SearchOrder;
use frontend\modules\catalog\models\ItalianProduct;
use frontend\modules\shop\models\CartCustomerForm;

/**
 * Class OrderController
 *
 * @package frontend\modules\shop\controllers
 */
class OrderController extends BaseController
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
                        'actions' => ['list', 'view'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['link'],
                        'roles' => ['@']
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create'],
                    ],
                    [
                        'allow' => false,
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'view' => ['get'],
                    'link' => ['get'],
                    'create' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionList()
    {
        $orders = Order::findByUserId(Yii::$app->getUser()->id);

        $this->title = Yii::t('app', 'Orders');

        return $this->render('list', [
            'orders' => $orders,
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws ForbiddenHttpException
     */
    public function actionView($id)
    {
        $order = Order::findByIdUserId($id, Yii::$app->getUser()->id);

        if (empty($order) || Yii::$app->getUser()->isGuest) {
            throw new ForbiddenHttpException('Access denied');
        }

        return $this->render('view', [
            'order' => $order,
        ]);
    }

    /**
     * @param $token
     * @return string|\yii\web\Response
     */
    public function actionLink($token)
    {
        $order = Order::findByLink($token);

        if (empty($order)) {
            return $this->redirect(Url::toRoute('/home/home/index'));
        }

        return $this->render('view', [
            'order' => $order,
        ]);
    }

    /**
     * @param $product_id
     * @return \yii\web\Response
     */
    public function actionCreate($product_id)
    {
        $customerForm = new CartCustomerForm();
        $customerForm->setScenario('frontend');

        if ($customerForm->load(Yii::$app->getRequest()->post(), 'CartCustomerForm') && $customerForm->validate()) {
            // сначала добавляем покупателя и получаем его id
            $customer_id = SearchOrder::addNewCustomer($customerForm);

            $order = new Order();
            $order->scenario = 'addNewOrder';

            $order->setAttributes($customerForm->getAttributes());

            if ($customerForm->country_code) {
                $order->country_id = $customerForm->country->id;
            }

            if (ItalianProduct::findById($product_id) != null) {
                $order->product_type = 'sale-italy';
            } else {
                $order->product_type = 'product';
            }

            $order->lang = Yii::$app->language;
            $order->customer_id = $customer_id;

            $session = Yii::$app->session;
            $order->order_first_url_visit = $session->get('order_first_url_visit');
            $order->order_count_url_visit = $session->get('order_count_url_visit');
            $order->order_mobile = Yii::$app->getModule('shop')->isMobileDevice();

            //$session->remove('order_first_url_visit');
            //$session->remove('order_count_url_visit');

            if ($order->validate() && $order->save()) {
                $orderItem = new OrderItem();
                $orderItem->scenario = 'addNewOrderItem';

                $orderItem->order_id = $order->id;
                $orderItem->product_id = $product_id;
                $orderItem->count = 1;

                $orderItem->save();

                /**
                 * send user letter
                 */
                Yii::$app
                    ->mailer
                    ->compose(
                        '/../mail/new_order_user_letter',
                        [
                            'model' => $order,
                            'customerForm' => $customerForm,
                            'order' => $order,
                            'text' => ($order->product_type == 'product')
                                ? Yii::$app->param->getByName('MAIL_SHOP_ORDER_TEXT')
                                : Yii::$app->param->getByName('MAIL_SHOP_ORDER_TEXT_FOR_SALE_ITALY')
                        ]
                    )
                    ->setTo($customerForm['email'])
                    ->setSubject(
                        Yii::t('app', 'Your order № {order_id}', ['order_id' => $order['id']])
                    )
                    ->send();

                return Yii::$app->controller->redirect(Url::toRoute(['/shop/cart/notepad', 'order' => 'good']));
            }
        }

        return $this->redirect(Yii::$app->request->referrer);
    }
}
