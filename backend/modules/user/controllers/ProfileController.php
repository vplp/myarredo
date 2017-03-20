<?php

namespace backend\modules\user\controllers;

use Yii;
use yii\web\NotFoundHttpException;
//
use thread\app\base\controllers\BackendController;
use thread\actions\Update;
use thread\actions\fileapi\{
    DeleteAction, UploadAction
};
//
use backend\modules\user\models\{
    Profile
};

/**
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class ProfileController extends BackendController
{
    public $name = 'profile';
    public $title = "Profile";
    protected $model = Profile::class;
    public $defaultAction = 'update';
    public $actionListLinkStatus = ['/user/user/list'];
    protected $user_id = null;

    /**
     *
     * @return array
     */
    public function actions()
    {
        $model = Profile::find()->byId(Yii::$app->getRequest()->get('id', 0))->one();

        return [
            'update' => [
                'class' => Update::class,
                'modelClass' => $this->model,
                'redirect' => function () {
                    return $_POST['save_and_exit'] ? ['/user/user/list'] : ['update', 'id' => $this->action->getModel()->id];
                }
            ],
            'fileupload' => [
                'class' => UploadAction::class,
                'path' => $this->module->getAvatarUploadPath($model['user_id'])
            ],
            'filedelete' => [
                'class' => DeleteAction::class,
                'path' => $this->module->getAvatarUploadPath($model['user_id'])
            ],
        ];
    }

    public function beforeAction($action)
    {

        $actionName = $this->action->id;
        if (in_array($actionName, ['fileupload', 'filedelete'])) {
            $model = Profile::find()->byId(Yii::$app->getRequest()->get('id', 0))->one();
            if ($model === null) {
                throw new NotFoundHttpException;
            }
            $this->user_id = $model['user_id'];
        }
        return true;
    }
}
