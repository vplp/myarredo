<?php

namespace frontend\modules\shop\controllers;

use Yii;
use yii\web\Response;
use frontend\components\BaseController;

/**
 * Class CartController
 *
 * @package frontend\modules\shop\controllers
 */
class CartController extends BaseController
{
    public $title = "Cart";
    public $layout = "@app/layouts/main";

    /**
     * My notepad
     *
     * @return string
     */
    public function actionIndex()
    {
        $this->title = 'Мой блокнот';

        $view = (empty(Yii::$app->shop_cart->items)) ? 'empty' : 'index';

        return $this->render($view);
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
        if (Yii::$app->request->isAjax) {
            Yii::$app->getResponse()->format = Response::FORMAT_JSON;
            $product_id = Yii::$app->getRequest()->post('product_id');
            $count = Yii::$app->getRequest()->post('count') ?? 0;

            return Yii::$app->shop_cart->deleteItem($product_id, $count);
        }
    }
}