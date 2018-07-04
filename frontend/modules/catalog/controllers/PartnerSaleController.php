<?php

namespace frontend\modules\catalog\controllers;

use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
//
use frontend\components\BaseController;
use frontend\modules\catalog\models\{
    Sale, SaleLang, search\Sale as filterSaleModel
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
 * Class PartnerSaleController
 *
 * @package frontend\modules\catalog\controllers
 */
class PartnerSaleController extends BaseController
{
    public $title = "Partner Sale";

    public $defaultAction = 'list';

    protected $model = Sale::class;
    protected $modelLang = SaleLang::class;
    protected $filterModel = filterSaleModel::class;

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
                        'roles' => ['partner'],
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
                    'path' => $this->module->getSaleUploadPath()
                ],
                'filedelete' => [
                    'class' => DeleteAction::class,
                    'useHashPath' => true,
                    'path' => $this->module->getSaleUploadPath()
                ],
            ]
        );
    }
}
