<?php

namespace frontend\modules\banner\controllers;

use yii\helpers\ArrayHelper;
//
use common\actions\upload\{
    DeleteAction, UploadAction
};
//
use frontend\components\BaseController;
//
use frontend\modules\banner\models\{
    BannerItem, BannerItemLang, search\BannerItem as filterBannerItem
};
use thread\actions\{
    CreateWithLang, UpdateWithLang, ListModel
};

/**
 * Class FactoryBannerController
 *
 * @package frontend\modules\banner\controllers
 */
class FactoryBannerController extends BaseController
{
    public $title = 'Banner';

    protected $model = BannerItem::class;

    protected $modelLang = BannerItemLang::class;
    protected $filterModel = filterBannerItem::class;

    /**
     * @return array
     */
    public function actions()
    {
        return ArrayHelper::merge(
            parent::actions(),
            [
                'list' => [
                    'class' => ListModel::class,
                    'modelClass' => $this->model,
                    //'layout' => '@app/layouts/list',
                    'filterModel' => $this->filterModel,
                ],
                'create' => [
                    'class' => CreateWithLang::class,
                    'modelClass' => $this->model,
                    'modelClassLang' => $this->modelLang,
                    'redirect' => function () {
                        return ['update', 'id' => $this->action->getModel()->id];
                    }
                ],
                'update' => [
                    'class' => UpdateWithLang::class,
                    'modelClass' => $this->model,
                    'modelClassLang' => $this->modelLang,
                    'redirect' => function () {
                        return ['update', 'id' => $this->action->getModel()->id];
                    }
                ],
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