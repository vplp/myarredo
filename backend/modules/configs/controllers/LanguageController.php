<?php
namespace backend\modules\configs\controllers;

use thread\app\base\controllers\BackendController;
use thread\actions\fileapi\{
    DeleteAction, UploadAction
};
//
use backend\modules\configs\models\{
    Language, search\Language as filterLanguageModel
};
use thread\actions\{
    Create, ListModel, Update
};
use Yii;
use yii\helpers\ArrayHelper;

/**
 * @author Alla Kuzmenko
 */
class LanguageController extends BackendController
{
    public $model = Language::class;
    public $filterModel = filterLanguageModel::class;
    public $title = 'Language';

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
                'path' => Yii::$app->getModule('configs')->getFlagUploadUrl()
            ],
            'filedelete' => [
                'class' => DeleteAction::class,
                'path' => Yii::$app->getModule('configs')->getFlagUploadUrl()
            ],
        ]);
    }

}
