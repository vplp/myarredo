<?php

namespace frontend\modules\catalog\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Response;
use yii\web\ForbiddenHttpException;
use frontend\components\BaseController;
use frontend\modules\catalog\models\{
    Category,
    Collection,
    SubTypes,
    FactoryProduct,
    FactoryProductLang,
    search\FactoryProduct as filterFactoryProductModel
};
use thread\actions\{
    CreateWithLang, ListModel, AttributeSwitch, UpdateWithLang
};
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
                        'roles' => ['factory'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['ajax-get-category'],
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
     * @return array
     */
    public function actions()
    {
        $this->title = Yii::t('app', 'My goods');

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
     * @param $action
     * @return bool|Response
     * @throws ForbiddenHttpException
     * @throws \yii\web\NotFoundHttpException
     */
    public function beforeAction($action)
    {
        $id = Yii::$app->request->get('id', null);

        if (in_array($action->id, ['update', 'intrash'])) {
            if ($id === null) {
                throw new \yii\web\NotFoundHttpException();
            }
        }

        if ($id !== null && Yii::$app->getRequest()->get('step') != 'promotion') {
            $model = FactoryProduct::findById($id);

            if (!Yii::$app->getUser()->isGuest && $model != null && $model['user_id'] != Yii::$app->user->identity->id) {
                throw new ForbiddenHttpException('Access denied');
            }
        }

        return parent::beforeAction($action);
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
            $response['subtypes'] = SubTypes::dropDownList(['parent_id' => $type_id]);
        }

        return $response;
    }
}
