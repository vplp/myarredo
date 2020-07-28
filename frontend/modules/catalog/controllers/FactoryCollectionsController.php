<?php

namespace frontend\modules\catalog\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use yii\web\{
    ForbiddenHttpException, NotFoundHttpException
};
use frontend\components\BaseController;
use frontend\modules\catalog\models\{
    FactoryCollection, search\Collection as filterCollectionModel
};
use thread\actions\{
    Create, Update, ListModel
};

/**
 * Class FactoryCollectionsController
 *
 * @package frontend\modules\catalog\controllers
 */
class FactoryCollectionsController extends BaseController
{
    public $title = '';

    public $defaultAction = 'list';

    protected $model = FactoryCollection::class;
    protected $filterModel = filterCollectionModel::class;

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
        $this->title = Yii::t('app', 'Collections');

        return ArrayHelper::merge(
            parent::actions(),
            [
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
            ]
        );
    }

    /**
     * @param $action
     * @return bool
     * @throws ForbiddenHttpException
     * @throws \yii\web\BadRequestHttpException
     * @throws \yii\web\NotFoundHttpException
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
            $model = FactoryCollection::findById($id);

            if ($model != null && $model['user_id'] != Yii::$app->user->identity->id) {
                throw new ForbiddenHttpException('Access denied');
            }
        }

        return parent::beforeAction($action);
    }
}
