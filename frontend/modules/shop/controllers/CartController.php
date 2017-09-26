<?php

namespace frontend\modules\shop\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\Response;
use frontend\components\BaseController;
use frontend\modules\shop\models\{
    CartCustomerForm,
    Order,
    search\Order as SearchOrder
};

/**
 * Class CartController
 *
 * @package frontend\modules\shop\controllers
 */
class CartController extends BaseController
{
    public $label = "Cart";
    public $title = "Cart";
    public $layout = "@app/layouts/main";

    /**
     * @return string
     */
    public function actionIndex()
    {
        $this->title = 'Мой блокнот';

        $view = (empty(Yii::$app->shop_cart->items)) ? 'empty' : 'index';

        return $this->render($view);
    }

//    /**
//     * @return string|Response
//     */
//    public function actionCheckout()
//    {
//        $customerForm = new CartCustomerForm;
//        $customerForm->setScenario('frontend');
//
//        if (
//            $customerForm->load(Yii::$app->getRequest()->post(),'CartCustomerForm') &&
//            $customerForm->validate() &&
//            !empty(Yii::$app->shop_cart->items)
//        ) {
//            // Додаємо новий заказ до БД
//            $new_order = SearchOrder::addNewOrder(Yii::$app->shop_cart->cart, $customerForm);
//
//            if ($new_order) {
//
//                $order = Order::findById($new_order['id']);
//
//                // user letter
//                Yii::$app
//                    ->mailer
//                    ->compose(
//                        'new_order',
//                        [
//                            'model' => $new_order,
//                            'customerForm' => $customerForm,
//                            'order' => $order,
//                        ]
//                    )
//                    ->setTo($customerForm['email'])
//                    ->setSubject(Yii::t('app', 'Your order № {order_id}', ['order_id' => $new_order['id']]))
//                    ->send();
//
//                // admin letter
//                Yii::$app
//                    ->mailer
//                    ->compose(
//                        'new_order',
//                        [
//                            'model' => $new_order,
//                            'customerForm' => $customerForm,
//                            'order' => $order,
//                        ]
//                    )
//                    ->setTo(Yii::$app->params['adminEmail'])
//                    ->setSubject(Yii::t('app', 'New order № {order_id}', ['order_id' => $new_order['id']]))
//                    ->send();
//
//                // clear cart
//                Yii::$app->shop_cart->deleteCart();
//
//                // message
//                Yii::$app->getSession()->setFlash(
//                    'message',
//                    Yii::t('app', 'Your order № {order_id}', ['order_id' => $new_order['id']])
//                );
//
//                return $this->redirect(Url::toRoute(['/shop/cart/send-order']));
//            }
//        }
//
//        $view = (Yii::$app->shop_cart->items === null) ? 'empty' : 'checkout';
//
//        $this->label = 'Оформление заказа';
//
//        return $this->render($view, [
//            'model' => $customerForm,
//        ]);
//    }

    /**
     *
     * @return string
     */
    public function actionSendOrder()
    {
        return $this->render('empty');
    }

    /**
     * добавление товара в корзину
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
     * удаление товара из попапа корзину
     */
    public function actionDeleteFromCart()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->getResponse()->format = Response::FORMAT_JSON;
            $product_id = Yii::$app->getRequest()->post('product_id');
            $count = Yii::$app->getRequest()->post('count') ?? 0;
            return Yii::$app->shop_cart->deleteItem($product_id, $count);
        }
    }
}