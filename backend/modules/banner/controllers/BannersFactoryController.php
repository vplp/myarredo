<?php

namespace backend\modules\banner\controllers;

use yii\helpers\ArrayHelper;
use common\actions\upload\{
    DeleteAction, UploadAction
};
use thread\app\base\controllers\BackendController;
use backend\modules\banner\models\{
    BannerItemFactory, BannerItemLang, search\BannerItemFactory as filterBannerItemFactoryModel
};

/**
 * Class BannersFactoryController
 *
 * @package backend\modules\banner\controllers
 */
class BannersFactoryController extends BackendController
{
    public $model = BannerItemFactory::class;
    public $modelLang = BannerItemLang::class;
    public $filterModel = filterBannerItemFactoryModel::class;
    public $title = 'Banners for factories';
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
