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

            $currency = Currency::findByCode2('EUR');

            /** @var Currency $amount */

            /**
             * cost 1 product = 10 EUR
             * conversion to RUB
             */
            $cost = 10 * $currency->course;

            $amount = $cost + ($cost * 0.02);
            $amount = number_format($amount, 2, '.', '');

            $total = count($models) * $amount;
            $nds = number_format($total / 100 * 20, 2, '.', '');

            $discount_percent = 50;
            $discount_money = number_format($total / 100 * $discount_percent, 2, '.', '');

            $modelPayment->amount = number_format($total + $nds - $discount_money, 2, '.', '');
            $modelPayment->currency = 'RUB';

            return $this->render('payment', [
                'models' => $models,
                'modelPayment' => $modelPayment,
                'amount' => $amount,
                'total' => $total,
                'nds' => $nds,
                'discount_percent' => $discount_percent,
                'discount_money' => $discount_money,
                'currency' => $currency,
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
                'create' => [
                    'class' => CreateWithLang::class,
                    'modelClass' => $this->model,
                    'modelClassLang' => $this->modelLang,
                    'scenario' => 'frontend',
                    'redirect' => function () {
                        return ['update', 'id' => $this->action->getModel()->id, 'step' => 'image'];
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
}
