<?php

namespace frontend\modules\shop\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\helpers\Url;
use frontend\components\BaseController;
use frontend\modules\shop\models\{
    CartCustomerForm,
    FormFindProduct,
    Order,
    search\Order as SearchOrder
};
use yii\web\UploadedFile;

/**
 * Class CartController
 *
 * @package frontend\modules\shop\controllers
 */
class CartController extends BaseController
{
    public $title = "Cart";
    public $defaultAction = 'notepad';

    /**
     * @return array
     */
    public function behaviors()
    {
        $behaviors = [
            [
                'class' => VerbFilter::class,
                'actions' => [
                    'ajax-get-request-find-product' => ['post'],
                    'request-find-product' => ['post'],
                ],
            ],
        ];

        return $behaviors;
    }
    /**
     * @return array
     */
    public function actionAjaxGetRequestFindProduct()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->getResponse()->format = Response::FORMAT_JSON;

            $model = new FormFindProduct(['scenario' => 'frontend']);

            $html = $this->renderPartial('ajax_request_find_product', [
                'model' => $model,
            ]);

            return ['success' => 1, 'html' => $html];
        }
    }
    /**
     * @return bool|Response
     */
    public function actionRequestFindProduct()
    {
        $customerForm = new FormFindProduct();
        $customerForm->setScenario('frontend');

        if ($customerForm->load(Yii::$app->getRequest()->post(), 'FormFindProduct') && $customerForm->validate()) {
            // сначала добавляем покупателя и получаем его id
            $customer_id = SearchOrder::addNewCustomer($customerForm);

            /**
             * новый заказ
             */
            $order = new Order();
            $order->scenario = 'addNewOrder';

            // переносим все атрибуты из заполненой формы в заказ
            $order->setAttributes($customerForm->getAttributes());

            if ($customerForm->country_code) {
                $order->country_id = $customerForm->country->id;
            }
            $order->product_type = 'product';
            $order->lang = Yii::$app->language;
            $order->customer_id = $customer_id;
            $order->generateToken();

            $session = Yii::$app->session;
            $order->order_first_url_visit = $session->get('order_first_url_visit');
            $order->order_count_url_visit = $session->get('order_count_url_visit');
            $order->order_mobile = Yii::$app->getModule('shop')->isMobileDevice();

            //$session->remove('order_first_url_visit');
            //$session->remove('order_count_url_visit');

            $file = UploadedFile::getInstance($customerForm, 'image_link');

            if ($file && $file->error == UPLOAD_ERR_OK) {
                $path = Yii::$app->getModule('shop')->getOrderUploadPath();

                @mkdir($path, 0777, true);

                $file->name = uniqid() . '.' . $file->extension;
                $file->saveAs($path . '/' . $file->name);
                $order->image_link = $file->name;
            }

            /** @var PDO $transaction */
            $transaction = $order::getDb()->beginTransaction();
            try {
                if ($order->save()) {
                    $transaction->commit();

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

                    // message
                    Yii::$app->getSession()->setFlash(
                        'success',
                        Yii::t('app', 'Отправлено')
                    );
                } else {
                    $transaction->rollBack();
                }
            } catch (Exception $e) {
                Yii::getLogger()->log($e->getMessage(), Logger::LEVEL_ERROR);
                $transaction->rollBack();
                return false;
            }
        }

        $this->title = Yii::t('app', 'Не нашли то что искали? Оставьте заявку тут');

        return $this->render('request_find_product', [
            'model' => $customerForm
        ]);

        //return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Notepad
     *
     * @return string
     */
    public function actionNotepad()
    {
        $this->title = Yii::t('app', 'Мой блокнот');

        $customerForm = new CartCustomerForm();
        $customerForm->setScenario('frontend');

        if (Yii::$app->getRequest()->get('order') && Yii::$app->getRequest()->get('order') == 'good') {
            return $this->render('order_success');
        }

        if ($customerForm->load(Yii::$app->getRequest()->post(), 'CartCustomerForm') &&
            $customerForm->validate() &&
            !empty(Yii::$app->shop_cart->items)
        ) {
            /**
             * create new order
             */
            $new_order = SearchOrder::addNewOrder(Yii::$app->shop_cart->cart, $customerForm);

            /** @var $new_order Order */
            if ($new_order) {
                $order = Order::findById($new_order['id']);

                /**
                 * send user letter
                 */
                Yii::$app
                    ->mailer
                    ->compose(
                        '/../mail/new_order_user_letter',
                        [
                            'model' => $new_order,
                            'customerForm' => $customerForm,
                            'order' => $order,
                            'text' => ($new_order->product_type == 'product')
                                ? Yii::$app->param->getByName('MAIL_SHOP_ORDER_TEXT')
                                : Yii::$app->param->getByName('MAIL_SHOP_ORDER_TEXT_FOR_SALE_ITALY')
                        ]
                    )
                    ->setTo($customerForm['email'])
                    ->setSubject(
                        Yii::t('app', 'Your order № {order_id}', ['order_id' => $new_order['id']])
                    )
                    ->send();

                /**
                 * clear cart
                 */
                Yii::$app->shop_cart->deleteCart();

                return Yii::$app->controller->redirect(Url::toRoute(['/shop/cart/notepad', 'order' => 'good']));
            }
        }

        return $this->render('notepad');
    }

    /**
     * Add product to cart
     *
     * @return bool
     */
    public function actionAddToCart()
    {
        $product_id = Yii::$app->getRequest()->post('id');
        $count = Yii::$app->getRequest()->post('count') ?? 1;
        $extra_param = Yii::$app->getRequest()->post('extra_param') ?? [];

        if (Yii::$app->getRequest()->post('flag') == 'request-price') {
            foreach (Yii::$app->shop_cart->items as $item) {
                Yii::$app->shop_cart->deleteItem($item['product_id']);
            }
        }

        if (Yii::$app->shop_cart->addItem($product_id, $count, $extra_param)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Delete product from cart
     *
     * @return mixed
     */
    public function actionDeleteFromCart()
    {
        if (Yii::$app->request->isAjax && Yii::$app->getRequest()->post('product_id')) {
            Yii::$app->getResponse()->format = Response::FORMAT_JSON;

            $product_id = Yii::$app->getRequest()->post('product_id');
            $count = Yii::$app->getRequest()->post('count') ?? 0;

            return Yii::$app->shop_cart->deleteItem($product_id, $count);
        }
    }
}
