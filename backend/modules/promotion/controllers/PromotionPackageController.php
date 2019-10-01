<?php

namespace backend\modules\promotion\controllers;

use yii\helpers\ArrayHelper;
//
use common\actions\upload\{
    DeleteAction, UploadAction
};
//
use backend\modules\promotion\models\{
    PromotionPackage, PromotionPackageLang, search\PromotionPackage as filterPromotionPackageModel
};
//
use thread\app\base\controllers\BackendController;

/**
 * Class PromotionPackageController
 *
 * @package backend\modules\promotion\controllers
 */
class PromotionPackageController extends BackendController
{
    public $model = PromotionPackage::class;
    public $modelLang = PromotionPackageLang::class;
    public $filterModel = filterPromotionPackageModel::class;
    public $title = 'Promotion package';
    public $name = 'promotion';

    /**
     * @return array
     */
    public function actions()
    {
        return ArrayHelper::merge(parent::actions(), [
            'fileupload' => [
                'class' => UploadAction::class,
                'useHashPath' => true,
                'path' => $this->module->getUploadPath()
            ],
            'filedelete' => [
                'class' => DeleteAction::class,
                'useHashPath' => true,
                'path' => $this->module->getUploadPath()
            ],
        ]);
    }
}
