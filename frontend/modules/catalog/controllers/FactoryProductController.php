<?php

namespace frontend\modules\catalog\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use yii\web\Response;
use yii\web\ForbiddenHttpException;
//
use frontend\components\BaseController;
use frontend\modules\catalog\models\{
    Category, Collection, FactoryProduct, FactoryProductLang, search\FactoryProduct as filterFactoryProductModel
};
//
use thread\actions\{
    CreateWithLang, ListModel, AttributeSwitch, UpdateWithLang
};
//
use common\actions\upload\{
    DeleteAction, UploadAction
};

/**
 * Class FactoryProductController
 *
 * @package frontend\modules\catalog\controllers
 */
class FactoryProductController extends BaseController
{
    public $title = '';

    public $defaultAction = 'list';

    protected $model = FactoryProduct::class;
    protected $modelLang = FactoryProductLang::class;
    protected $filterModel = filterFactoryProductModel::class;

    /**
     * @return array
     * @throws ForbiddenHttpException
     * @throws \Throwable
     */
    public function behaviors()
    {
        if (Yii::$app->getUser()->getIdentity()->group->role == 'factory' &&
            !Yii::$app->getUser()->getIdentity()->profile->factory_id) {
            throw new ForbiddenHttpException(Yii::t('app', 'Access denied without factory id.'));
        }

        return [
            'AccessControl' => [
                'class' => AccessControl::class,
                'rules' => [
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
        $this->title = Yii::t('app', 'My goods');

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
                    'redirect' => function () {
                        return ['update', 'id' => $this->action->getModel()->id];
                    }
                ],
                'update' => [
                    'class' => UpdateWithLang::class,
                    'modelClass' => $this->model,
                    'modelClassLang' => $this->modelLang,
                    'scenario' => 'frontend',
                    'redirect' => function () {
                        return ['update', 'id' => $this->action->getModel()->id];
                    }
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
                'promotion' => [
                    'class' => AttributeSwitch::class,
                    'modelClass' => $this->model,
                    'attribute' => 'promotion',
                    'redirect' => $this->defaultAction,
                ],
            ]
        );
    }

    /**
     * @return array
     */
    public function actionAjaxGetCollection()
    {
        $response = [];
        Yii::$app->getResponse()->format = Response::FORMAT_JSON;

        if (Yii::$app->request->isAjax && $factory_id = Yii::$app->request->post('factory_id')) {
            $response['collection'] = Collection::dropDownList(['factory_id' => $factory_id]);
        }

        return $response;
    }

    /**
     * @return array
     */
    public function actionAjaxGetCategory()
    {
        $response = [];
        Yii::$app->getResponse()->format = Response::FORMAT_JSON;

        if (Yii::$app->request->isAjax && $type_id = Yii::$app->request->post('type_id')) {
            $response['category'] = Category::dropDownList(['type_id' => $type_id]);
        }

        return $response;
    }
}
