<?php

namespace frontend\modules\catalog\controllers;

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
use frontend\modules\payment\models\Payment;
//
use common\components\YandexKassaAPI\actions\ConfirmPaymentAction;
use common\components\YandexKassaAPI\actions\CreatePaymentAction;
//
use thread\actions\{
    ListModel,
    AttributeSwitch
};

/**
 * Class FactoryPromotionController
 *
 * @package frontend\modules\catalog\controllers
 */
class FactoryPromotionController extends BaseController
{
    public $title = '';

    public $defaultAction = 'list';

    protected $model = FactoryPromotion::class;
    protected $filterModel = filterFactoryPromotionModel::class;

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
                        'actions' => ['notify'],
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
     * @return array
     */
    public function actions()
    {
        $this->title = Yii::t('app', 'Рекламная кампания');

        return ArrayHelper::merge(
            parent::actions(),
            [
                'list' => [
                    'class' => ListModel::class,
                    'modelClass' => $this->model,
                    'filterModel' => $this->filterModel,
                ],
                'intrash' => [
                    'class' => AttributeSwitch::class,
                    'modelClass' => $this->model,
                    'attribute' => 'deleted',
                    'redirect' => $this->defaultAction,
                ],
                'create-payment' => [
                    'class' => CreatePaymentAction::class,
                    'orderClass' => FactoryPromotion::class,
                    'beforePayment' => function ($order) {
                        return $order->payment_status == FactoryPromotion::PAYMENT_STATUS_PENDING;
                    }
                ],
                'notify' => [
                    'class' => ConfirmPaymentAction::class,
                    'orderClass' => FactoryPromotion::class,
                    'beforeConfirm' => function ($payment, $order) {
                        $order->payment_status = $payment->object->paid
                            ? FactoryPromotion::PAYMENT_STATUS_SUCCESS
                            : FactoryPromotion::PAYMENT_STATUS_PENDING;

                        $order->payment_object = json_encode($payment);

                        $order->setScenario('setPaymentStatus');

                        return $order->save();
                    }
                ]
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function actionCreate()
    {
        $model = new FactoryPromotion();

        $modelFactoryProduct = new FactoryProduct();
        $filterModelFactoryProduct = new filterFactoryProductModel();

        $filterModelFactoryProduct->load(Yii::$app->getRequest()->get());

        $dataProviderFactoryProduct = $modelFactoryProduct->search(
            ArrayHelper::merge(Yii::$app->getRequest()->get(), ['pagination' => false])
        );

        $dataProviderFactoryProduct->sort = false;

        $model->scenario = 'frontend';

        if ($model->load(Yii::$app->getRequest()->post())) {
            /** @var Transaction $transaction */
            $transaction = $model::getDb()->beginTransaction();
            try {
                $model->status = 1;
                $model->published = 1;

                $save = $model->save();

                if ($save) {
                    $transaction->commit();

                    if (Yii::$app->getRequest()->post('payment')) {
                        $this->crateInvoice($model);
                    } else {
                        return $this->redirect(Url::toRoute([
                            '/catalog/factory-promotion/update',
                            'id' => $model->id
                        ]));
                    }
                } else {
                    $transaction->rollBack();
                }
            } catch (Exception $e) {
                $transaction->rollBack();
            }
        }

        return $this->render('_form', [
            'model' => $model,
            'dataProviderFactoryProduct' => $dataProviderFactoryProduct,
            'filterModelFactoryProduct' => $filterModelFactoryProduct,
        ]);
    }

    /**
     * @inheritdoc
     */
    public function actionUpdate($id)
    {
        $model = FactoryPromotion::findById($id);

        /** @var $model FactoryPromotion */

        if ($model == null) {
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }

        $modelFactoryProduct = new FactoryProduct();
        $filterModelFactoryProduct = new filterFactoryProductModel();

        $filterModelFactoryProduct->load(Yii::$app->getRequest()->get());

        $dataProviderFactoryProduct = $modelFactoryProduct->search(
            ArrayHelper::merge(Yii::$app->getRequest()->get(), ['pagination' => false])
        );

        $dataProviderFactoryProduct->sort = false;

        $model->scenario = 'frontend';

        if ($model->load(Yii::$app->getRequest()->post())) {
            /** @var Transaction $transaction */
            $transaction = $model::getDb()->beginTransaction();
            try {
                $save = $model->save();

                if ($save) {
                    $transaction->commit();

                    if (Yii::$app->getRequest()->post('payment')) {
                        $this->crateInvoice($model);
                    }
                } else {
                    $transaction->rollBack();
                }
            } catch (Exception $e) {
                $transaction->rollBack();
            }
        }

        $cities = [];
        foreach ($model->city_ids as $city_id) {
            $city = City::findById($city_id);

            $cities[$city->country_id][] = $city_id;
        }
        $model->city_ids = $cities;

        return $this->render($model->payment_status == FactoryPromotion::PAYMENT_STATUS_SUCCESS ? 'view' : '_form', [
            'model' => $model,
            'dataProviderFactoryProduct' => $dataProviderFactoryProduct,
            'filterModelFactoryProduct' => $filterModelFactoryProduct,
        ]);
    }

    /**
     * @param FactoryPromotion $model
     * @return mixed
     * @throws \yii\base\InvalidConfigException
     */
    protected function crateInvoice(FactoryPromotion $model)
    {
        $modelPayment = new Payment();
        $modelPayment->setScenario('frontend');

        $modelPayment->user_id = Yii::$app->user->id;
        $modelPayment->type = 'factory_promotion';
        $modelPayment->amount = $model->amount;
        $modelPayment->currency = 'RUB';
        $modelPayment->items_ids = [$model->id];

        /** @var Transaction $transaction */
        $transaction = $modelPayment::getDb()->beginTransaction();
        try {
            $modelPayment->payment_status = Payment::PAYMENT_STATUS_PENDING;

            $save = $modelPayment->save();

            if ($save) {
                $transaction->commit();

                /** @var \robokassa\Merchant $merchant */
                $merchant = Yii::$app->get('robokassa');

                return $merchant->payment(
                    $modelPayment->amount,
                    $modelPayment->id,
                    Yii::t('app', 'Оплата рекламной кампании'),
                    null,
                    Yii::$app->user->identity->email,
                    substr(Yii::$app->language, 0, 2)
                );
            } else {
                $transaction->rollBack();
            }
        } catch (Exception $e) {
            $transaction->rollBack();
        }
    }
}
