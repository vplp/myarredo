<?php

namespace frontend\modules\catalog\controllers;

use common\components\robokassa\actions\{
    ResultAction, SuccessAction, FailAction
};
use frontend\modules\location\models\City;
use Yii;
use yii\db\Exception;
use yii\db\Transaction;
use yii\helpers\{
    ArrayHelper, Url
};
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
//
use frontend\components\BaseController;
use frontend\modules\catalog\models\{
    FactoryPromotion,
    search\FactoryPromotion as filterFactoryPromotionModel,
    FactoryProduct,
    search\FactoryProduct as filterFactoryProductModel
};
//
use common\components\YandexKassaAPI\actions\ConfirmPaymentAction;
use common\components\YandexKassaAPI\actions\CreatePaymentAction;
//
use thread\actions\{
    ListModel,
    AttributeSwitch
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
            Yii::$app->getUser()->getIdentity()->group->role == 'factory' &&
            !Yii::$app->getUser()->getIdentity()->profile->factory_id) {
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

        /** @var \robokassa\Merchant $merchant */
        $merchant = Yii::$app->get('robokassa');

        return $merchant->payment(/*$model->amount*/1, $model->id, 'Оплата рекламной компании', null, Yii::$app->user->identity->email);
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
        $this->loadModel($nInvId)->updateAttributes(['status' => FactoryPromotion::PAYMENT_STATUS_ACCEPTED]);
        return $this->goBack();
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
        $this->loadModel($nInvId)->updateAttributes(['status' => FactoryPromotion::PAYMENT_STATUS_SUCCESS]);
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
        if ($model->status == FactoryPromotion::STATUS_PENDING) {
            $model->updateAttributes(['status' => FactoryPromotion::PAYMENT_STATUS_FAIL]);
            return 'Ok';
        } else {
            return 'Status has not changed';
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    protected function loadModel($id)
    {
        $model = FactoryPromotion::find($id);
        if ($model === null) {
            throw new BadRequestHttpException();
        }
        return $model;
    }
}
