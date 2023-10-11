<?php

namespace frontend\modules\catalog\controllers;

use Yii;
use yii\helpers\{
    ArrayHelper, Url
};
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;
use frontend\actions\UpdateWithLang;
use frontend\components\BaseController;
use frontend\modules\catalog\models\{
    ItalianProduct, ItalianProductLang, search\ItalianProduct as filterItalianProductModel
};
use frontend\modules\payment\models\Payment;
use frontend\modules\location\models\Currency;
use common\actions\upload\{
    DeleteAction, UploadAction
};
use thread\actions\{
    CreateWithLang, ListModel, AttributeSwitch
};

/**
 * Class ItalianProductController
 *
 * @package frontend\modules\catalog\controllers
 */
class ItalianProductController extends BaseController
{
    public $title = "";

    public $defaultAction = 'list';

    protected $model = ItalianProduct::class;
    protected $modelLang = ItalianProductLang::class;
    protected $filterModel = filterItalianProductModel::class;

    /**
     * @return array
     * @throws ForbiddenHttpException
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
                        'roles' => ['partner', 'factory'],
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
     * @throws ForbiddenHttpException
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public function actionPayment()
    {
        $this->title = Yii::t('app', 'Furniture in Italy');

        if ($ids = Yii::$app->getRequest()->get('id')) {
            $models = ItalianProduct::findByIDsUserId($ids, Yii::$app->getUser()->id);

            if ($models == null) {
                throw new ForbiddenHttpException('Access denied');
            }

            $modelPayment = new Payment();
            $modelPayment->setScenario('frontend');

            $modelPayment->user_id = Yii::$app->user->id;
            $modelPayment->type = 'italian_item';
            $modelPayment->change_tariff = Yii::$app->getRequest()->get('change_tariff') ? 1 : 0;

            $count = count($models);

            $modelCostProduct = ItalianProduct::getCostPlacementProduct($count);

            $modelPayment->amount = $modelCostProduct['amount'];
            $modelPayment->currency = $modelCostProduct['currency'];

            return $this->render('payment', [
                'models' => $models,
                'modelPayment' => $modelPayment,
                'amount' => $modelCostProduct['amount'],
                'total' => $modelCostProduct['total'],
                'nds' => $modelCostProduct['nds'],
                'discount_percent' => $modelCostProduct['discount_percent'],
                'discount_money' => $modelCostProduct['discount_money'],
                'currency' => $modelCostProduct['currency'],
            ]);
        } else {
            throw new ForbiddenHttpException('Access denied');
        }
    }

    /**
     * @param $id
     * @return string
     * @throws ForbiddenHttpException
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public function actionInterestPayment($id)
    {
        $this->title = Yii::t('app', 'Furniture in Italy');

        /** @var ItalianProduct $model */
        $model = ItalianProduct::findById($id);

        if ($model == null || $model->create_mode != 'free') {
            throw new ForbiddenHttpException('Access denied');
        }

        $modelPayment = new Payment();
        $modelPayment->setScenario('frontend');

        $modelPayment->user_id = Yii::$app->user->id;
        $modelPayment->type = 'italian_item';

        $modelCostProduct = ItalianProduct::getFreeCostPlacementProduct($model);

        $modelPayment->amount = $modelCostProduct['amount'];
        $modelPayment->currency = $modelCostProduct['currency'];

        return $this->render('interest_payment', [
            'model' => $model,
            'modelPayment' => $modelPayment,
            'amount' => $modelCostProduct['amount'],
            'currency' => $modelCostProduct['currency'],
        ]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws \yii\base\InvalidConfigException
     */
    public function actionOnModeration($id)
    {
        /** @var $model ItalianProduct */
        $model = ItalianProduct::findById($id);

        if ($model == null) {
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }

        $model->scenario = 'setStatus';

        if ($model->status == 'not_considered') {
            $transaction = $model::getDb()->beginTransaction();
            try {
                $model->status = 'on_moderation';

                if ($model->save()) {
                    /** send mail to admin */

                    $title = $model->getTitle();

                    $message = 'Бесплатное размещение товара отправлено на модерацию';

                    Yii::$app
                        ->mailer
                        ->compose(
                            'letter_notification_for_admin',
                            [
                                'title' => $title,
                                'message' => $message,
                                'url' => Url::home(true) . 'backend/catalog/sale-italy/update?id=' . $model->id,
                            ]
                        )
                        ->setTo(\Yii::$app->params['mailer']['setTo'])
                        ->setSubject($title)
                        ->send();
                }

                $transaction->commit();

                return $this->redirect(
                    Url::toRoute([
                        '/catalog/italian-product/payment',
                        '_csrf' => Yii::$app->getRequest()->getCsrfToken(),
                        'id[]' => $model->id,
                        'change_tariff' => 1
                    ])
                );
            } catch (\Exception $e) {
                $transaction->rollBack();
            }
        }

        return $this->redirect([$this->defaultAction]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws \yii\base\InvalidConfigException
     */
    public function actionChangeTariff($id)
    {
        /** @var $model ItalianProduct */
        $model = ItalianProduct::findById($id);

        if ($model == null) {
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }

        $model->scenario = 'create_mode';

        if ($model->create_mode == 'paid' && $model->user_id = Yii::$app->getUser()->id) {
            $transaction = $model::getDb()->beginTransaction();
            try {
                $model->create_mode = 'free';

                $model->save();

                $transaction->commit();
            } catch (\Exception $e) {
                $transaction->rollBack();
            }
        }

        return $this->redirect([$this->defaultAction]);
    }

    /**
     * @return array
     */
    public function actions()
    {

        if (Yii::$app->request->get('step') == 'photo') {
            $scenario = 'setImages';
            $link = function () {
                return Url::to(['update', 'id' => $this->action->getModel()->id, 'step' => 'check']);
            };
        } else {
            $scenario = 'frontend';
            $link = function () {
                return Url::to(['update', 'id' => $this->action->getModel()->id, 'step' => 'photo']);
            };
        }

        return ArrayHelper::merge(
            parent::actions(),
            [
                'list' => [
                    'class' => ListModel::class,
                    'modelClass' => $this->model,
                    'filterModel' => $this->filterModel,
                ],
                'completed' => [
                    'class' => ListModel::class,
                    'modelClass' => $this->model,
                    'methodName' => 'completed',
                    'view' => 'completed',
                    'filterModel' => $this->filterModel,
                ],
                'free-create' => [
                    'class' => CreateWithLang::class,
                    'modelClass' => $this->model,
                    'modelClassLang' => $this->modelLang,
                    'scenario' => 'frontend',
                    'redirect' => function () {
                        return ['update', 'id' => $this->action->getModel()->id, 'step' => 'photo'];
                    }
                ],
                'update' => [
                    'class' => UpdateWithLang::class,
                    'modelClass' => $this->model,
                    'modelClassLang' => $this->modelLang,
                    'scenario' => $scenario,
                    'redirect' => $link
                ],
                'intrash' => [
                    'class' => AttributeSwitch::class,
                    'modelClass' => $this->model,
                    'attribute' => 'deleted',
                    'redirect' => function () {
                        return ['list'];
                    }
                ],
                'is-sold' => [
                    'class' => AttributeSwitch::class,
                    'modelClass' => $this->model,
                    'attribute' => 'is_sold',
                    'redirect' => $this->defaultAction,
                ],
                'fileupload' => [
                    'class' => UploadAction::class,
                    'useHashPath' => true,
                    'path' => $this->module->getProductUploadPath()
                ],
                'filedelete' => [
                    'class' => DeleteAction::class,
                    'useHashPath' => true,
                    'path' => $this->module->getProductUploadPath()
                ],
                'one-file-upload' => [
                    'class' => UploadAction::class,
                    'path' => $this->module->getItalianProductFileUploadPath(),
                    'uploadOnlyImage' => false,
                    'unique' => false
                ],
                'one-file-delete' => [
                    'class' => DeleteAction::class,
                    'path' => $this->module->getItalianProductFileUploadPath()
                ],
            ]
        );
    }

    /**
     * @param $action
     * @return bool
     * @throws ForbiddenHttpException
     * @throws \yii\web\NotFoundHttpException
     */
    public function beforeAction($action)
    {
        $id = Yii::$app->request->get('id', null);

        if (in_array($action->id, ['update', 'published'])) {
            if ($id === null) {
                throw new \yii\web\NotFoundHttpException();
            }
        }

        if ($id !== null) {
            $model = ItalianProduct::findById($id);
            /** @var $model ItalianProduct */
            if ($action->id == 'published' && $model != null && $model->create_mode == 'paid') {
                throw new ForbiddenHttpException('Access denied');
            }
        }

        $this->title = isset(Yii::$app->user->identity->profile->factory) && Yii::$app->user->identity->profile->factory->producing_country_id == 4
            ? Yii::t('app', 'Furniture in Italy')
            : Yii::t('app', 'Наличие на складе');

        return parent::beforeAction($action);
    }
}
