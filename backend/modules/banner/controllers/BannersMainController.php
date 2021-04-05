<?php

namespace backend\modules\banner\controllers;

use yii\helpers\ArrayHelper;
use common\actions\upload\{
    DeleteAction, UploadAction
};
use thread\app\base\controllers\BackendController;
use backend\modules\banner\models\{
    BannerItemMain, BannerItemLang, search\BannerItemMain as filterBannerItemMainModel
};

/**
 * Class BannersMainController
 *
 * @package backend\modules\banner\controllers
 */
class BannersMainController extends BackendController
{
    public $model = BannerItemMain::class;
    public $modelLang = BannerItemLang::class;
    public $filterModel = filterBannerItemMainModel::class;
    public $title = 'Banners for main';
    public $name = 'banner';

    /**
     * @return array
     */
    public function actions()
    {
        return ArrayHelper::merge(
            parent::actions(),
            [
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
