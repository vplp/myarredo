<?php

namespace frontend\modules\payment\controllers;

use Yii;
use yii\web\ForbiddenHttpException;
use yii\filters\AccessControl;
//
use frontend\components\BaseController;
use frontend\modules\payment\models\Payment;
//
use common\components\robokassa\actions\{
    ResultAction, SuccessAction, FailAction
};

/**
 * Class PaymentController
 *
 * @package frontend\modules\payment\controllers
 */
class PaymentController extends BaseController
{
    public $title = '';

    protected $model = Payment::class;

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
                        'roles' => ['factory', 'partner'],
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
     * @throws \yii\base\InvalidConfigException
     */
    public function actionInvoice()
    {
        $model = new Payment();
        $model->setScenario('frontend');

        if ($model->load(Yii::$app->getRequest()->post()) && $model->validate()) {
            /** @var Transaction $transaction */
            $transaction = $model::getDb()->beginTransaction();
            try {
                $model->payment_status = Payment::PAYMENT_STATUS_PENDING;

                /* !!! */ echo  '<pre style="color:red;">'; print_r($model->attributes); echo '</pre>'; /* !!! */
                die;
                $save = $model->save();

                if ($save) {
                    $transaction->commit();

                    /** @var \robokassa\Merchant $merchant */
                    $merchant = Yii::$app->get('robokassa');

                    return $merchant->payment(
                        $model->amount,
                        $model->id,
                        ($model->type == 'factory_promotion') ? 'Оплата рекламной компании' : 'Оплата товаров',
                        null,
                        Yii::$app->user->identity->email
                    );
                } else {
                    $transaction->rollBack();
                }
            } catch (Exception $e) {
                $transaction->rollBack();
            }
        }
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

        /** @var Payment $model */
        $model->setScenario('setPaymentStatus');
        $model->payment_status = Payment::PAYMENT_STATUS_SUCCESS;
        $model->payment_time = time();
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

        /** @var Payment $model */
        $model->setScenario('setPaymentStatus');
        $model->payment_status = Payment::PAYMENT_STATUS_SUCCESS;
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

        /** @var Payment $model */

        if ($model->payment_status == Payment::PAYMENT_STATUS_PENDING) {
            $model->setScenario('setPaymentStatus');
            $model->payment_status = Payment::PAYMENT_STATUS_FAIL;
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
        $model = Payment::findOne($id);

        if ($model === null) {
            throw new BadRequestHttpException();
        }

        return $model;
    }
}
