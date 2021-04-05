<?php

namespace backend\modules\banner\controllers;

use yii\helpers\ArrayHelper;
use common\actions\upload\{
    DeleteAction, UploadAction
};
use thread\app\base\controllers\BackendController;
use backend\modules\banner\models\{
    BannerItemCatalog, BannerItemLang, search\BannerItemCatalog as filterBannerItemCatalogModel
};

/**
 * Class BannersCatalogController
 *
 * @package backend\modules\banner\controllers
 */
class BannersCatalogController extends BackendController
{
    public $model = BannerItemCatalog::class;
    public $modelLang = BannerItemLang::class;
    public $filterModel = filterBannerItemCatalogModel::class;
    public $title = 'Banners for catalog';
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
