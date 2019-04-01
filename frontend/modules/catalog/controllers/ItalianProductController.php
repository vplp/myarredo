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

        if ($ids = Yii::$app->getRequest()->post('id')) {
            $models = ItalianProduct::findByIDsUserId($ids, Yii::$app->getUser()->id);

            if ($models == null) {
                throw new ForbiddenHttpException('Access denied');
            }

            $modelPayment = new Payment();
            $modelPayment->setScenario('frontend');

            $modelPayment->user_id = Yii::$app->user->id;
            $modelPayment->type = 'italian_item';

            /**
             * cost 1 product = 5 EUR
             * conversion to RUB
             */
            $cost = 0.2;

            $currency = Currency::findByCode2('EUR');
            /** @var Currency $amount */
            $amount = ($cost * $currency->course + 1 * $currency->course + 0.12 * $currency->course);

            $modelPayment->amount = number_format(
                ceil(count($models) * $amount),
                2,
                '.',
                ''
            );
            $modelPayment->currency = 'RUB';

            return $this->render('payment', [
                'models' => $models,
                'modelPayment' => $modelPayment,
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
            $link = function () {
                return Url::to(['update', 'id' => $this->action->getModel()->id, 'step' => 'check']);
            };
        } else {
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
                'create' => [
                    'class' => CreateWithLang::class,
                    'modelClass' => $this->model,
                    'modelClassLang' => $this->modelLang,
                    'scenario' => 'frontend',
                    'layout' => 'italian_product_form',
                    'redirect' => function () {
                        return ['update', 'id' => $this->action->getModel()->id, 'step' => 'image'];
                    }
                ],
                'update' => [
                    'class' => UpdateWithLang::class,
                    'modelClass' => $this->model,
                    'modelClassLang' => $this->modelLang,
                    'scenario' => 'frontend',
                    'layout' => 'italian_product_form',
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
