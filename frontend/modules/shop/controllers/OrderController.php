<?php

namespace frontend\modules\shop\controllers;

use Yii;
use yii\helpers\Url;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;
//
use frontend\components\BaseController;
use frontend\modules\shop\models\Order;

/**
 * Class OrderController
 *
 * @package frontend\modules\shop\controllers
 */
class OrderController extends BaseController
{
    public $title = '';
    public $defaultAction = 'list';

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'AccessControl' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['list', 'view'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['link'],
                        'roles' => ['@']
                    ],
                    [
                        'allow' => false,
                    ],
                ],
            ],
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
        $orders = Order::findByUserId(Yii::$app->getUser()->id);

        $this->title = Yii::t('app', 'Orders');

        return $this->render('list', [
            'orders' => $orders,
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws ForbiddenHttpException
     */
    public function actionView($id)
    {
        $order = Order::findByIdUserId($id, Yii::$app->getUser()->id);

        if (empty($order) || Yii::$app->getUser()->isGuest) {
            throw new ForbiddenHttpException('Access denied');
        }

        return $this->render('view', [
            'order' => $order,
        ]);
    }

    /**
     * @param $token
     * @return string|\yii\web\Response
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