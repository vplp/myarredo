<?php

namespace frontend\modules\catalog\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\helpers\{
    ArrayHelper, Url
};
use yii\web\{
    ForbiddenHttpException, NotFoundHttpException
};
//
use thread\actions\{
    Create, Update, ListModel
};
//
use common\actions\upload\{
    DeleteAction, UploadAction
};
//
use frontend\components\BaseController;
use frontend\modules\catalog\models\{
    FactoryPricesFiles,
    search\FactoryPricesFiles as filterFactoryPricesFiles
};

/**
 * Class FactoryPricesFilesController
 *
 * @package frontend\modules\catalog\controllers
 */
class FactoryPricesFilesController extends BaseController
{
    public $model = FactoryPricesFiles::class;
    public $filterModel = filterFactoryPricesFiles::class;
    public $title = 'Factory';
    public $name = 'factory';

    public $factory = null;

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
        $this->title = Yii::t('app', 'Прайс листы');

        $link = function () {
            return Url::to(
                [
                    '/catalog/factory/update',
                    'id' => ($this->factory !== null) ? $this->factory->id : 0,
                ]
            );
        };

        return ArrayHelper::merge(parent::actions(), [
            'trash' => [
                'redirect' => $link
            ],
            'list' => [
                'class' => ListModel::class,
                'modelClass' => $this->model,
                'filterModel' => $this->filterModel,
            ],
            'create' => [
                'class' => Create::class,
                'modelClass' => $this->model,
                'scenario' => 'frontend',
                'redirect' => function () {
                    return ['update', 'id' => $this->action->getModel()->id];
                }
            ],
            'update' => [
                'class' => Update::class,
                'modelClass' => $this->model,
                'scenario' => 'frontend',
                'redirect' => function () {
                    return ['update', 'id' => $this->action->getModel()->id];
                }
            ],
            'one-file-upload' => [
                'class' => UploadAction::class,
                'path' => $this->module->getFactoryPricesFilesUploadPath(),
                'uploadOnlyImage' => false,
                'unique' => false
            ],
            'one-file-delete' => [
                'class' => DeleteAction::class,
                'path' => $this->module->getFactoryPricesFilesUploadPath()
            ],
        ]);
    }

    /**
     * @param \yii\base\Action $action
     * @return bool
     * @throws ForbiddenHttpException
     * @throws NotFoundHttpException
     */
    public function beforeAction($action)
    {
        $id = Yii::$app->request->get('id', null);

        if (in_array($action->id, ['update'])) {
            if ($id === null) {
                throw new NotFoundHttpException();
            }
        }

        if ($id !== null) {
            $model = FactoryPricesFiles::findById($id);

            /** @var $model FactoryPricesFiles */
            if ($model != null && $model['factory_id'] != Yii::$app->user->identity->profile->factory_id && !empty($model->product)) {
                throw new ForbiddenHttpException('Access denied');
            }
        }

        return parent::beforeAction($action);
    }
}
