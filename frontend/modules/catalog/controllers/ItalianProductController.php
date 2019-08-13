<?php

namespace frontend\modules\catalog\controllers;

use Yii;
use yii\helpers\{
    ArrayHelper, Url
};
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;
//
use frontend\actions\UpdateWithLang;
use frontend\components\BaseController;
use frontend\modules\catalog\models\{
    ItalianProduct, ItalianProductLang, search\ItalianProduct as filterItalianProductModel
};
use frontend\modules\payment\models\Payment;
use frontend\modules\location\models\Currency;
//
use common\actions\upload\{
    DeleteAction, UploadAction
};
//
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
    public $title = "Furniture in Italy";

    public $defaultAction = 'list';

    protected $model = ItalianProduct::class;
    protected $modelLang = ItalianProductLang::class;
    protected $filterModel = filterItalianProductModel::class;

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
     * @inheritdoc
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

            $count = count($models);

            $modelCostProduct = ItalianProduct::getCostProduct($count);

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
                'paid-create' => [
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
//                'published' => [
//                    'class' => AttributeSwitch::class,
//                    'modelClass' => $this->model,
//                    'attribute' => 'published',
//                    'redirect' => $this->defaultAction,
//                ],
                'intrash' => [
                    'class' => AttributeSwitch::class,
                    'modelClass' => $this->model,
                    'attribute' => 'deleted',
                    'redirect' => $this->defaultAction,
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

        return parent::beforeAction($action);
    }
}
