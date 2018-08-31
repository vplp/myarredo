<?php

namespace frontend\modules\catalog\controllers;

use frontend\modules\location\models\City;
use Yii;
use yii\db\Exception;
use yii\db\Transaction;
use yii\helpers\{
    ArrayHelper, Url
};
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
//
use frontend\components\BaseController;
use frontend\modules\catalog\models\{
    FactoryPromotion,
    search\FactoryPromotion as filterFactoryPromotionModel,
    FactoryProduct,
    search\FactoryProduct as filterFactoryProductModel,
    FactoryPromotionPayment
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
     */
    public function behaviors()
    {
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
        $this->title = Yii::t('app', 'Рекламная компания');

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
                    'orderClass' => FactoryPromotion::className(),
                    'beforePayment' => function ($order) {
                        return $order->payment_status == FactoryPromotion::PAYMENT_STATUS_NEW;
                    }
                ],
                'notify' => [
                    'class' => ConfirmPaymentAction::class,
                    'orderClass' => FactoryPromotion::className(),
                    'beforeConfirm' => function ($payment, $order) {
                        $order->payment_status = $payment->object->paid
                            ? FactoryPromotion::PAYMENT_STATUS_PAID
                            : FactoryPromotion::PAYMENT_STATUS_NEW;

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
                $model->user_id = Yii::$app->user->identity->id;
                $model->status = 1;
                $model->published = 1;

                $save = $model->save();

                if ($save) {
                    $transaction->commit();

                    if (Yii::$app->getRequest()->post('payment')) {
                        return $this->redirect(Url::toRoute([
                            '/catalog/factory-promotion/create-payment',
                            'id' => $model->id
                        ]));
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
                        return $this->redirect(Url::toRoute([
                            '/catalog/factory-promotion/create-payment',
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

        $cities = [];
        foreach ($model->city_ids as $city_id) {
            $city = City::findById($city_id);

            $cities[$city->country_id][] = $city_id;
        }
        $model->city_ids = $cities;

        return $this->render('_form', [
            'model' => $model,
            'dataProviderFactoryProduct' => $dataProviderFactoryProduct,
            'filterModelFactoryProduct' => $filterModelFactoryProduct,
        ]);
    }
}
