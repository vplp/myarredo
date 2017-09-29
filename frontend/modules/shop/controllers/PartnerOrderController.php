<?php

namespace frontend\modules\shop\controllers;

use Yii;
use yii\filters\{
    VerbFilter, AccessControl
};
use yii\web\ForbiddenHttpException;
//
use frontend\components\BaseController;
use frontend\modules\shop\models\{
    Order, OrderAnswer, search\Order as filterOrderModel
};

/**
 * Class PartnerOrderController
 *
 * @package frontend\modules\shop\controllers
 */
class PartnerOrderController extends BaseController
{
    public $title = "PartnerOrder";

    public $defaultAction = 'list';

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'list' => ['get'],
                    'view' => ['get', 'post'],
                ],
            ],
            'AccessControl' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => [
                            'list',
                            'view'
                        ],
                        'roles' => ['partner'],
                    ],
                    [
                        'allow' => false,
                    ],
                ],
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionList()
    {
        $orders = Order::findBaseAll();

        $this->title = 'Заявки';

        $this->breadcrumbs[] = [
            'label' => $this->title,
        ];

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
        $model = Order::findById($id);

        if (empty($model) || Yii::$app->getUser()->isGuest) {
            throw new ForbiddenHttpException('Access denied');
        }

        $modelAnswer = OrderAnswer::findByOrderIdUserId($model->id, Yii::$app->getUser()->getId());

        if (empty($modelAnswer)) {
            $modelAnswer = new OrderAnswer();
        }

        $modelAnswer->setScenario('frontend');

        $modelAnswer->order_id = $model->id;
        $modelAnswer->user_id = Yii::$app->getUser()->getId();


        if ($modelAnswer->load(Yii::$app->getRequest()->post()) && $modelAnswer->validate()) {
            $transaction = $modelAnswer::getDb()->beginTransaction();
            try {
                $save = $modelAnswer->save();
                if ($save) {
                    $transaction->commit();
                } else {
                    $transaction->rollBack();
                }
            } catch (Exception $e) {
                $transaction->rollBack();
            }
        }

        $this->title = 'Заявка №'. $model->id;

        $this->breadcrumbs[] = [
            'label' => 'Заявки',
            'url' => ['/shop/partner-order/list']
        ];

        $this->breadcrumbs[] = [
            'label' => $this->title,
        ];

        return $this->render('view', [
            'model' => $model,
            'modelAnswer' => $modelAnswer,
        ]);
    }
}
