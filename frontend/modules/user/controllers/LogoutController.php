<?php

namespace frontend\modules\user\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;
//
use frontend\components\BaseController;

/**
 * Class UserController
 *
 * @package frontend\modules\user\controllers
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

        return $this->redirect(Yii::$app->getRequest()->hostInfo . Url::toRoute(['/']));
    }
}
