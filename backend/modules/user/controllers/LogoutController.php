<?php

namespace backend\modules\user\controllers;

use thread\app\base\controllers\BackendController;
use Yii;
use yii\filters\AccessControl;

/**
 * Class UserController
 *
 * @package admin\modules\user\controllers
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class LogoutController extends BackendController
{

    public $label = "Logout";
    public $title = "Logout";
    public $defaultAction = 'index';
    public $enableCsrfValidation = false;

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'AccessControl' => [
                'class' => AccessControl::class,
                'rules' => [
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

    public function actionIndex()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }
}
