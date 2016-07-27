<?php

namespace frontend\modules\user\controllers;

use frontend\components\BaseController;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;

/**
 * Class UserController
 *
 * @package frontend\modules\user\controllers
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class LogoutController extends BaseController
{

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
                        'actions' => ['index'],
                        'roles' => ['?'],
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
     * @return string
     */
    public function actionIndex()
    {
        Yii::$app->getUser()->logout();
        return $this->redirect(Url::toRoute('/home/home/index'));
    }
}
