<?php

namespace frontend\modules\shop\controllers;

use Yii;
use yii\helpers\Url;
use frontend\modules\shop\models\{
    Cart, CartCustomerForm, search\Order
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
    {   $cart = Cart::findBySessionID();
        $customerform = new CartCustomerForm;
        $customerform->setScenario('frontend');
        if ($customerform->load(Yii::$app->getRequest()->post(),
                'CartCustomerForm') && $customerform->validate() && (!empty($cart->items))
        ) {
            ////Додаємо новий заказ до БД
            $order_id = Order::addNewOrder($cart, $customerform);

            if ($order_id) {
                $cart = null;
                //$cart->delete(); -  не удаляем корзину для статистики

                Yii::$app->getSession()->setFlash('SEND_ORDER',
                    Yii::t('shop', 'Your order № {order_id} has been sent!', ['order_id' => $order_id])
                    . ' < br />' . Yii::t('shop', 'Our manager will contact you soon') .'!'. '<br/>');
                Yii::$app->getSession()->setFlash('SEND_ORDER_ID', $order_id);
                return $this->redirect(Url::toRoute(['/shop/cart/send-order']));
            }
        }
        $view = ($cart->items === null) ? 'empty' : 'index';

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
        $cart = null;
        if (Yii::$app->getSession()->getFlash('SEND_ORDER_ID') !== null) {
            $cart = Order::findById(Yii::$app->getSession()->getFlash('SEND_ORDER_ID'));
        }

        return $this->render('empty', ['cart' => $cart]);
    }


}
