<?php

namespace backend\modules\catalog\controllers;

use yii\helpers\ArrayHelper;
//
use common\actions\upload\{
    DeleteAction, UploadAction
};
//
use thread\app\base\controllers\BackendController;
use thread\actions\AttributeSwitch;
//
use backend\modules\catalog\models\{
    Sale, SaleLang, search\Sale as filterSale
};

/**
 * Class SaleController
 *
 * @package backend\modules\catalog\controllers
 */
class SaleController extends BackendController
{
    public $model = Sale::class;
    public $modelLang = SaleLang::class;
    public $filterModel = filterSale::class;
    public $title = 'Sale';
    public $name = 'sale';

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
        ]);
    }
}
