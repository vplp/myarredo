<?php

namespace backend\modules\catalog\controllers;

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use common\actions\upload\{
    DeleteAction, UploadAction
};
use thread\app\base\controllers\BackendController;
use thread\actions\AttributeSwitch;
use backend\modules\catalog\models\{
    ItalianProduct, ItalianProductLang, search\ItalianProduct as filterItalianProduct
};

/**
 * Class SaleItalyController
 *
 * @package backend\modules\catalog\controllers
 */
class SaleItalyController extends BackendController
{
    public $model = ItalianProduct::class;
    public $modelLang = ItalianProductLang::class;
    public $filterModel = filterItalianProduct::class;
    public $title = 'Sale in Italy';
    public $name = 'Sale in Italy';

    public function behaviors()
    {
        return [
            'AccessControl' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['error'],
                        'roles' => ['?', '@'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['admin', 'catalogEditor'],
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
        return ArrayHelper::merge(parent::actions(), [
            'on_main' => [
                'class' => AttributeSwitch::class,
                'modelClass' => $this->model,
                'attribute' => 'on_main',
                'redirect' => $this->defaultAction,
            ],
            'bestseller' => [
                'class' => AttributeSwitch::class,
                'modelClass' => $this->model,
                'attribute' => 'bestseller',
                'redirect' => $this->defaultAction,
            ],
            'is_sold' => [
                'class' => AttributeSwitch::class,
                'modelClass' => $this->model,
                'attribute' => 'is_sold',
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
        ]);
    }
}
