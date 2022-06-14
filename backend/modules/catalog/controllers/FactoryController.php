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
    Factory, FactoryLang, search\Factory as filterFactory
};

/**
 * Class FactoryController
 *
 * @package backend\modules\catalog\controllers
 */
class FactoryController extends BackendController
{
    public $model = Factory::class;
    public $modelLang = FactoryLang::class;
    public $filterModel = filterFactory::class;
    public $title = 'Factory';
    public $name = 'factory';

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
                        'actions' => ['list', 'update'],
                        'roles' => ['seo'],
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
            'show_for_ru' => [
                'class' => AttributeSwitch::class,
                'modelClass' => $this->model,
                'attribute' => 'show_for_ru',
                'redirect' => $this->defaultAction,
            ],
            'show_for_by' => [
                'class' => AttributeSwitch::class,
                'modelClass' => $this->model,
                'attribute' => 'show_for_by',
                'redirect' => $this->defaultAction,
            ],
            'show_for_ua' => [
                'class' => AttributeSwitch::class,
                'modelClass' => $this->model,
                'attribute' => 'show_for_ua',
                'redirect' => $this->defaultAction,
            ],
            'show_for_com' => [
                'class' => AttributeSwitch::class,
                'modelClass' => $this->model,
                'attribute' => 'show_for_com',
                'redirect' => $this->defaultAction,
            ],
            'show_for_de' => [
                'class' => AttributeSwitch::class,
                'modelClass' => $this->model,
                'attribute' => 'show_for_de',
                'redirect' => $this->defaultAction,
            ],
            'to_translate' => [
                'class' => AttributeSwitch::class,
                'modelClass' => $this->model,
                'attribute' => 'to_translate',
                'redirect' => $this->defaultAction,
            ],
            'fileupload' => [
                'class' => UploadAction::class,
                'path' => $this->module->getFactoryUploadPath()
            ],
            'filedelete' => [
                'class' => DeleteAction::class,
                'path' => $this->module->getFactoryUploadPath()
            ],
        ]);
    }
}
