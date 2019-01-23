<?php

namespace frontend\modules\catalog\controllers;

use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
//
use frontend\components\BaseController;
use frontend\modules\catalog\models\{
    ItalianProduct, ItalianProductLang, search\ItalianProduct as filterItalianProductModel
};
//
use thread\actions\{
    CreateWithLang, ListModel, AttributeSwitch
};
use frontend\actions\UpdateWithLang;
//
use common\actions\upload\{
    DeleteAction, UploadAction
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
            ]
        );
    }
}
