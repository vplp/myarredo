<?php

namespace frontend\modules\shop\controllers;

use Yii;
use yii\web\Response;
use frontend\components\BaseController;
use frontend\modules\shop\widgets\cart\Cart;
use frontend\modules\shop\models\{
    CartCustomerForm,
    Order,
    search\Order  as SearchOrder
};

/**
 * Class WidgetController
 *
 * @package frontend\modules\shop\controllers
 */
class WidgetController extends BaseController
{
    public $title = "Cart";
    public $defaultAction = 'index';

    /**
     * Екшин для того чтобы можно было обновить мальнькую корзину без перезагрузки страницы
     * @return string
     */
    public function actionIndex()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->getResponse()->format = Response::FORMAT_JSON;

            /**
             * всегда нужно перезагружать маленькие корзинки
             */
            $views['short'] = Cart::widget(['view' => 'short']);

            /**
             * рефрешим либо попап либо полную корзину
             */
            $view = Yii::$app->getRequest()->post('view');
            $view = Cart::widget(['view' => $view]);

            return [
                'success' => '1',
                'view' => $view,
                'views' => $views,
            ];
        }
    }

    /**
     * @return array
     */
    public function actionCheckout()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->getResponse()->format = Response::FORMAT_JSON;

            $customerForm = new CartCustomerForm;
            $customerForm->setScenario('frontend');

            return [
                'success' => '1',
                'view' => $this->renderPartial('checkout_popup', [
                    'model' => $customerForm,
                ])
            ];
        }
    }
}