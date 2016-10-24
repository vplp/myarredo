<?php

namespace frontend\modules\shop\controllers;

use Yii;
use yii\helpers\Url;
use frontend\modules\shop\models\{
    Order, Cart, CartCustomerForm, Customer
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
        $cart = Cart::findBySessionID();
        $customerform = new CartCustomerForm;
        $customerform->setScenario('frontend');
        if ($customerform->load(Yii::$app->getRequest()->post(), 'CartCustomerForm') && $customerform->validate()) {


            ////Додаємо нового відвідувача до БД
            $customer_id = Customer::addNewCustomer($customerform);
            if (empty($customer_id)) {
                //ошибка
            }
            $this->moveCartToOrderList();

            //$this->sendCardOrder($cart, $customerform);
            //'Ваш заказ № ' . $cart['id'] . ' отправлен:. <br/>Наш менеджер свяжется с вами в ближайшее время.<br/>'

            //$cart->delete();
            $cart = null;
//


            return $this->redirect(Url::toRoute(['/shop/cart/sendorder']));
        }

        $view = ($cart === null) ? 'empty' : 'index';

        return $this->render($view, [
            'cart' => $cart,
            'customerform' => $customerform,
        ]);
    }


    /**
     *
     * @return type
     */
    public function actionSendOrder()
    {
        $cart = null;
        if (Yii::$app->getSession()->getFlash('SEND_ORDER_ID') !== null) {
            $cart = Cart::find()->byId(Yii::$app->getSession()->getFlash('SEND_ORDER_ID'));
        }

        return $this->render('empty', ['cart' => $cart]);
    }

    /**
     * Send Order to Manager Mail
     */
    public function sendCardOrder($cart, $customerform)
    {
        Yii::$app->mailer->compose('/mail/letter-order', [
            'cart' => $cart,
            'customerform' => $customerform,
        ])
            ->setFrom(Yii::$app->params['mail']['from'])
            ->setTo(Yii::$app->params['mail']['to'])
            ->setSubject('Заказ №' . $cart['id'])
            ->send();

        //
    }

    /**
     * Add Order
     */
    public function moveCartToOrderList($cart, $customerform)
    {
        $order = new Order();
        $order->scenario = 'frontend';
        //$model->user_id = $params['user_id'];


        $transaction = $model::getDb()->beginTransaction();
        try {
            if ($model->save()) {
                $transaction->commit();
                return $model->id;
            } else {
                $transaction->rollBack();
            }

        } catch (Exception $e) {
            Yii::getLogger()->log($e->getMessage(), Logger::LEVEL_ERROR);
            $transaction->rollBack();
        }




    }


}
