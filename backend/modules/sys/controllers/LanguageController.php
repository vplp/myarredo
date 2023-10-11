<?php

namespace backend\modules\sys\controllers;

use Yii;
use yii\helpers\ArrayHelper;
//
use thread\app\base\controllers\BackendController;
use thread\actions\{
    Create, ListModel, Update
};
use common\actions\upload\{
    DeleteAction, UploadAction
};
//
use backend\modules\sys\models\{
    Language, search\Language as filterLanguageModel
};


/**
 * Class LanguageController
 *
 * @package backend\modules\sys\controllers
 */
class LanguageController extends BackendController
{
    public $model = Language::class;
    public $filterModel = filterLanguageModel::class;
    public $title = 'Language';
    public $name = 'language';

    public function actions()
    {

        return ArrayHelper::merge(parent::actions(), [
            'list' => [
                'class' => ListModel::class,
                'modelClass' => $this->model,

            ],
            'create' => [
                'class' => Create::class,
            ],
            'update' => [
                'class' => Update::class,
            ],
            'fileupload' => [
                'class' => UploadAction::class,
                'path' => $this->module->getFlagUploadPath()
            ],
            'filedelete' => [
                'class' => DeleteAction::class,
                'path' => $this->module->getFlagUploadPath()
            ],
        ]);
    }

}
