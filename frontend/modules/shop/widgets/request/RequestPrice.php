<?php

namespace frontend\modules\shop\widgets\request;

use Yii;
use yii\helpers\Url;
use yii\base\Widget;
use frontend\modules\shop\models\{
    CartCustomerForm,
    Order,
    search\Order  as SearchOrder
};

/**
 * Class RequestPrice
 *
 * @package frontend\modules\shop\widgets\cart
 */
class RequestPrice extends Widget
{
    public $view = 'request_price_form';

    /**
     * @return string
     */
    public function run()
    {
        $model = new CartCustomerForm;
        $model->setScenario('frontend');

        if (
            $model->load(Yii::$app->getRequest()->post(),'CartCustomerForm') &&
            $model->validate() &&
            !empty(Yii::$app->shop_cart->items)
        ) {
            // Додаємо новий заказ до БД
            $new_order = SearchOrder::addNewOrder(Yii::$app->shop_cart->cart, $model);

            if ($new_order) {

                $order = Order::findById($new_order['id']);

                // user letter
                Yii::$app
                    ->mailer
                    ->compose(
                        'new_order',
                        [
                            'model' => $new_order,
                            'customerForm' => $model,
                            'order' => $order,
                        ]
                    )
                    ->setTo($model['email'])
                    ->setSubject(Yii::t('app', 'Your order № {order_id}', ['order_id' => $new_order['id']]))
                    ->send();

                // admin letter
//                Yii::$app
//                    ->mailer
//                    ->compose(
//                        'new_order',
//                        [
//                            'model' => $new_order,
//                            'customerForm' => $model,
//                            'order' => $order,
//                        ]
//                    )
//                    ->setTo(Yii::$app->params['adminEmail'])
//                    ->setSubject(Yii::t('app', 'New order № {order_id}', ['order_id' => $new_order['id']]))
//                    ->send();

                // clear cart
                Yii::$app->shop_cart->deleteCart();

                // message
                Yii::$app->getSession()->setFlash(
                    'message',
                    Yii::t('app', 'Your order № {order_id}', ['order_id' => $new_order['id']])
                );

                return Yii::$app->controller->redirect(Url::toRoute(['/shop/cart/send-order']));
            }
        }

        return $this->render($this->view, [
            'model' => $model,
        ]);
    }
}