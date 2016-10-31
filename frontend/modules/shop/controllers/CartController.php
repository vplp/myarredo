<?php

namespace frontend\modules\shop\controllers;

use Yii;
use yii\helpers\Url;
use frontend\modules\shop\models\{
   CartCustomerForm, search\Order
};

/**
 * Class CartController
 *
 * @package frontend\modules\shop\controllers
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2014, Thread
 */
class CartController extends \frontend\components\BaseController
{

    public $title = "Cart";
    public $layout = "@app/layouts/main";
    public $defaultAction = 'index';

    /**
     *
     * @return string
     */
    public function actionIndex()
    {
        //Yii::$app->shop_cart->cart; - компонент корзина
        $customerform = new CartCustomerForm;
        $customerform->setScenario('frontend');
        if ($customerform->load(Yii::$app->getRequest()->post(),
                'CartCustomerForm') && $customerform->validate() && (!empty(Yii::$app->shop_cart->items))
        ) {
            ////Додаємо новий заказ до БД
            $order_id = Order::addNewOrder(Yii::$app->shop_cart->cart, $customerform);

            if ($order_id) {
                //$cart->delete(); -  не удаляем корзину для статистики

                Yii::$app->getSession()->setFlash('SEND_ORDER',
                    Yii::t('shop', 'Your order № {order_id} has been sent!', ['order_id' => $order_id])
                    . ' < br />' . Yii::t('shop', 'Our manager will contact you soon') . '!' . '<br/>');
                Yii::$app->getSession()->setFlash('SEND_ORDER_ID', $order_id);
                return $this->redirect(Url::toRoute(['/shop/cart/send-order']));
            }
        }
        $view = (Yii::$app->shop_cart->items === null) ? 'empty' : 'index';

        return $this->render($view, [
            'customerform' => $customerform,
        ]);
    }



    /**
     *
     * @return string
     */
    public function actionSendOrder()
    {
        return $this->render('empty');
    }


    /**
     *добавление товара в корзину
     */
    public function actionAddToCart()
    {
        $product_id = Yii::$app->getRequest()->post('id');
        $count = Yii::$app->getRequest()->post('count') ?? 1;
        $extra_param = Yii::$app->getRequest()->post('extra_param') ?? [];

        if (Yii::$app->shop_cart->addItem($product_id, $count, $extra_param)) {
            return true;
        } else {
            return false;
        }

    }


    /**
     *удаление товара из попапа корзину
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
