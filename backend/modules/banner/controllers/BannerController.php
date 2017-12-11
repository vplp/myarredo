<?php

namespace backend\modules\banner\controllers;

use yii\helpers\ArrayHelper;
//
use common\actions\upload\{
    DeleteAction, UploadAction
};
//
use thread\app\base\controllers\BackendController;
//
use backend\modules\banner\models\{
    BannerItem, BannerItemLang, search\BannerItem as filterBannerItemModel
};

/**
 * Class BannerController
 *
 * @package backend\modules\banner\controllers
 */
class BannerController extends BackendController
{
    public $model = BannerItem::class;
    public $modelLang = BannerItemLang::class;
    public $filterModel = filterBannerItemModel::class;
    public $title = 'Banner';
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