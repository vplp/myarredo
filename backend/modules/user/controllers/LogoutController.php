<?php

namespace backend\modules\user\controllers;

use Yii;
use yii\filters\AccessControl;
//
use thread\app\base\controllers\BackendController;

/**
 * Class UserController
 *
 * @package admin\modules\user\controllers
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
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

    /**
     * @return mixed
     */
    public function actionIndex()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }
}
