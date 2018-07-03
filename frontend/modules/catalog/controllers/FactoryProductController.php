<?php

namespace frontend\modules\catalog\controllers;

use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
//
use frontend\components\BaseController;
use frontend\modules\catalog\models\{
    Product, ProductLang, search\Product as filterProductModel
};
//
use thread\actions\{
    CreateWithLang, ListModel, AttributeSwitch, UpdateWithLang
};
//use frontend\actions\UpdateWithLang;
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
    public $title = "FactoryProduct";

    public $defaultAction = 'list';

    protected $model = Product::class;
    protected $modelLang = ProductLang::class;
    protected $filterModel = filterProductModel::class;

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
