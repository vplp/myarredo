<?php

namespace frontend\modules\shop\controllers;

use Yii;
use yii\web\Response;
use yii\helpers\Url;
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
    public $title = "Cart";
    public $defaultAction = 'notepad';

    /**
     * Notepad
     *
     * @return string
     */
    public function actionNotepad()
    {
        $this->title = Yii::t('app','Мой блокнот');

        $model = new CartCustomerForm;
        $model->setScenario('frontend');

        if (Yii::$app->getRequest()->get('order') && Yii::$app->getRequest()->get('order') == 'good') {
            return $this->render('order_success');
        }

        if (
            $model->load(Yii::$app->getRequest()->post(), 'CartCustomerForm') &&
            $model->validate() &&
            !empty(Yii::$app->shop_cart->items)
        ) {
            // create new order
            $new_order = SearchOrder::addNewOrder(Yii::$app->shop_cart->cart, $model);

            if ($new_order) {

                $order = Order::findById($new_order['id']);

                // send user letter
                Yii::$app
                    ->mailer
                    ->compose(
                        '/../mail/new_order_user_letter',
                        [
                            'model' => $new_order,
                            'customerForm' => $model,
                            'order' => $order,
                        ]
                    )
                    ->setTo($model['email'])
                    ->setSubject(Yii::t('app', 'Your order № {order_id}', ['order_id' => $new_order['id']]))
                    ->send();

                // clear cart
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