<?php

namespace frontend\modules\banner\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;
//
use common\actions\upload\{
    DeleteAction, UploadAction
};
//
use frontend\components\BaseController;
//
use frontend\modules\banner\models\{
    BannerItem, BannerItemLang, search\BannerItem as filterBannerItem
};
use thread\actions\{
    CreateWithLang, UpdateWithLang, ListModel, AttributeSwitch
};

/**
 * Class FactoryBannerController
 *
 * @package frontend\modules\banner\controllers
 */
class FactoryBannerController extends BaseController
{
    public $title = 'Banner';

    public $defaultAction = 'list';

    protected $model = BannerItem::class;
    protected $modelLang = BannerItemLang::class;
    protected $filterModel = filterBannerItem::class;

    /**
     * @return array
     * @throws ForbiddenHttpException
     * @throws \Throwable
     */
    public function behaviors()
    {
        if (!Yii::$app->getUser()->isGuest &&
            Yii::$app->user->identity->group->role == 'factory') {
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
                    'redirect' => function () {
                        return ['update', 'id' => $this->action->getModel()->id];
                    }
                ],
                'update' => [
                    'class' => UpdateWithLang::class,
                    'modelClass' => $this->model,
                    'modelClassLang' => $this->modelLang,
                    'redirect' => function () {
                        return ['update', 'id' => $this->action->getModel()->id];
                    }
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
                    'path' => $this->module->getBannerUploadPath()
                ],
                'filedelete' => [
                    'class' => DeleteAction::class,
                    'path' => $this->module->getBannerUploadPath()
                ],
            ]
        );
    }
}
