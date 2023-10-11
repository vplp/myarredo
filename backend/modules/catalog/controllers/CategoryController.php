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
    Category, CategoryLang, search\Category as filterCategory
};

/**
 * Class CategoryController
 *
 * @package backend\modules\catalog\controllers
 */
class CategoryController extends BackendController
{
    public $model = Category::class;
    public $modelLang = CategoryLang::class;
    public $filterModel = filterCategory::class;
    public $title = 'Category';
    public $name = 'category';

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
            'popular' => [
                'class' => AttributeSwitch::class,
                'modelClass' => $this->model,
                'attribute' => 'popular',
                'redirect' => $this->defaultAction,
            ],
            'popular_by' => [
                'class' => AttributeSwitch::class,
                'modelClass' => $this->model,
                'attribute' => 'popular_by',
                'redirect' => $this->defaultAction,
            ],
            'fileupload' => [
                'class' => UploadAction::class,
                'path' => $this->module->getCategoryUploadPath()
            ],
            'filedelete' => [
                'class' => DeleteAction::class,
                'path' => $this->module->getCategoryUploadPath()
            ],
        ]);
    }
}
