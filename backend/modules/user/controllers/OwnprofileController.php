<?php

namespace backend\modules\user\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
//
use thread\app\base\controllers\BackendController;
use thread\actions\Update;
use common\actions\upload\{
    DeleteAction, UploadAction
};
//
use backend\modules\user\models\{
    Profile
};

/**
 * Class OwnprofileController
 *
 * @package backend\modules\user\controllers
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class OwnprofileController extends BackendController
{
    public $name = 'ownprofile';
    public $title = "Profile";
    protected $model = Profile::class;
    public $defaultAction = 'update';
    public $actionListLinkStatus = ['/user/user/list'];

    /**
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \Exception
     */
    public function init()
    {

        if (Yii::$app->getRequest()->get('id') != Yii::$app->getUser()->id) {
            throw new NotFoundHttpException();
        }

        return parent::init();
    }

    public function behaviors()
    {
        return [
            'AccessControl' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['error'],
                        'roles' => ['?', '@'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => false,
                    ],
                ],
            ],
        ];
    }

    /**
     *
     * @return array
     */
    public function actions()
    {
        $model = Profile::findByUserId(Yii::$app->getUser()->id);
        $user = $model->user;

        return [
            'update' => [
                'class' => Update::class,
                'modelClass' => $this->model,
                'redirect' => function () {
                    return $_POST['save_and_exit']
                        ? ['/user/user/list']
                        : ['update', 'id' => $this->action->getModel()->id];
                }
            ],
            'fileupload' => [
                'class' => UploadAction::class,
                'path' => $this->module->getAvatarUploadPath($user['id'])
            ],
            'filedelete' => [
                'class' => DeleteAction::class,
                'path' => $this->module->getAvatarUploadPath($user['id'])
            ],
        ];
    }
}
