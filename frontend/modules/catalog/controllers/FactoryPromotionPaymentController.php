<?php

namespace frontend\modules\catalog\controllers;

use Yii;
use yii\web\ForbiddenHttpException;
use yii\filters\AccessControl;
//
use frontend\components\BaseController;
use frontend\modules\catalog\models\{
    FactoryPromotion
};
//
use common\components\robokassa\actions\{
    ResultAction, SuccessAction, FailAction
};

/**
 * Class FactoryPromotionPaymentController
 *
 * @package frontend\modules\catalog\controllers
 */
class FactoryPromotionPaymentController extends BaseController
{
    public $title = '';

    protected $model = FactoryPromotion::class;

    /**
     * @return array
     * @throws \Throwable
     */
    public function behaviors()
    {
        if (!Yii::$app->getUser()->isGuest &&
            Yii::$app->user->identity->group->role == 'factory' &&
            !Yii::$app->user->identity->profile->factory_id) {
            throw new ForbiddenHttpException(Yii::t('app', 'Access denied without factory id.'));
        }

        return [
            'AccessControl' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['result', 'success', 'fail'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['factory'],
                    ],
                    [
                        'allow' => false,
                    ],
                ],
            ],
        ];
    }

    /**
     * @param $id
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function actionInvoice($id)
    {
        $model = FactoryPromotion::findOne($id);

        if ($model == null) {
            throw new HttpException(500, "Произошла ошибка исполнения платежа");
        }

        $model->setScenario('setPaymentStatus');
        $model->payment_status = FactoryPromotion::PAYMENT_STATUS_PENDING;
        $model->save();

        /** @var \robokassa\Merchant $merchant */
        $merchant = Yii::$app->get('robokassa');

        return $merchant->payment(
            $model->amount,
            $model->id,
            'Оплата рекламной компании',
            null,
            Yii::$app->user->identity->email
        );
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'result' => [
                'class' => ResultAction::class,
                'callback' => [$this, 'resultCallback'],
            ],
            'success' => [
                'class' => SuccessAction::class,
                'callback' => [$this, 'successCallback'],
            ],
            'fail' => [
                'class' => FailAction::class,
                'callback' => [$this, 'failCallback'],
            ],
        ];
    }

    /**
     * @param $merchant
     * @param $nInvId
     * @param $nOutSum
     * @param $shp
     * @return \yii\web\Response
     */
    public function successCallback($merchant, $nInvId, $nOutSum, $shp)
    {
        $model = $this->loadModel($nInvId);
        $model->setScenario('setPaymentStatus');
        $model->payment_status = FactoryPromotion::PAYMENT_STATUS_SUCCESS;
        $model->save();

        return $this->render(
            'success',
            [
                'messages' => 'Operation of payment is successfully completed',
            ]
        );
    }

    /**
     * @param $merchant
     * @param $nInvId
     * @param $nOutSum
     * @param $shp
     * @return string
     */
    public function resultCallback($merchant, $nInvId, $nOutSum, $shp)
    {
        $model = $this->loadModel($nInvId);
        $model->setScenario('setPaymentStatus');
        $model->payment_status = FactoryPromotion::PAYMENT_STATUS_SUCCESS;
        $model->save();

        return 'OK' . $nInvId;
    }

    /**
     * @param $merchant
     * @param $nInvId
     * @param $nOutSum
     * @param $shp
     * @return string
     */
    public function failCallback($merchant, $nInvId, $nOutSum, $shp)
    {
        $model = $this->loadModel($nInvId);

        if ($model->payment_status == FactoryPromotion::PAYMENT_STATUS_PENDING) {
            $model->setScenario('setPaymentStatus');
            $model->payment_status = FactoryPromotion::PAYMENT_STATUS_FAIL;
            $model->save();

            $messages = 'Ok';
        } else {
            $messages = 'Status has not changed';
        }

        return $this->render('fail', [
            'messages' => $messages,
        ]);
    }

    /**
     * @param $id
     * @return mixed
     */
    protected function loadModel($id)
    {
        $model = FactoryPromotion::findOne($id);

        if ($model === null) {
            throw new BadRequestHttpException();
        }

        return $model;
    }
}
