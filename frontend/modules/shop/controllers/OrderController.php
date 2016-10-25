<?php

namespace frontend\modules\shop\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use frontend\components\BaseController;
use frontend\modules\shop\models\Order;


/**
 * Class OrderController
 *
 * @package frontend\modules\shop\controllers
 * @author Alla Kuzmenko
 * @copyright (c) 2014, Thread
 */
class OrderController extends BaseController
{

    public $title = "Order";
    public $defaultAction = 'list';
    public $layout = "@app/layouts/main";

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'view' => ['get'],
                    'link' => ['get'],
                ],
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionList()
    {
        //TODO::когда заработает регистрация добавить связь юзера с покупателем, и добавить метод getCustomerId
        //$orders = Order::findByCustomerId($customer_id);
        $orders = Order::findByCustomerId(3);
        return $this->render('list', [
            'orders' => $orders,
        ]);
    }

    /**
     * @return string
     */
    public function actionView($id)
    {
        $order = Order::findById($id);

        if (empty($order || Yii::$app->getUser()->isGuest)) {
            return $this->redirect(Url::toRoute('/home/home/index'));
        }

        return $this->render('view', [
            'order' => $order,
        ]);
    }

    /**
     * @return string
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


}
