<?php

namespace backend\modules\banner\controllers;

use yii\helpers\ArrayHelper;
use common\actions\upload\{
    DeleteAction, UploadAction
};
use thread\app\base\controllers\BackendController;
use backend\modules\banner\models\{
    BannerItemBackground, BannerItemLang, search\BannerItemBackground as filterBannerItemBackgroundModel
};

/**
 * Class BannersBackgroundController
 *
 * @package backend\modules\banner\controllers
 */
class BannersBackgroundController extends BackendController
{
    public $model = BannerItemBackground::class;
    public $modelLang = BannerItemLang::class;
    public $filterModel = filterBannerItemBackgroundModel::class;
    public $title = 'Background banners';
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
