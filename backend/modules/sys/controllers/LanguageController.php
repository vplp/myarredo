<?php
namespace backend\modules\sys\controllers;

use Yii;
use yii\helpers\ArrayHelper;
//
use thread\app\base\controllers\BackendController;
use thread\actions\{
    Create, ListModel, Update
};
use thread\actions\fileapi\{
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
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
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
                'path' => Yii::$app->getModule('sys')->getFlagUploadUrl()
            ],
            'filedelete' => [
                'class' => DeleteAction::class,
                'path' => Yii::$app->getModule('sys')->getFlagUploadUrl()
            ],
        ]);
    }

}
