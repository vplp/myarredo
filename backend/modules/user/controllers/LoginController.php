<?php

namespace backend\modules\user\controllers;

use Yii;
use yii\filters\AccessControl;
//
use thread\app\base\controllers\BackendController;
use thread\modules\user\models\form\SignInForm;

/**
 * Class LoginController
 *
 * @package admin\modules\user\controllers
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class LoginController extends BackendController
{
    public $label = 'Login';
    public $title = "Login";
    public $layout = "@app/layouts/nologin";
    public $defaultAction = 'index';
    protected $model = SignInForm::class;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'AccessControl' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'captcha'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => false,
                    ],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'captcha' => [
                'class' => \yii\captcha\CaptchaAction::class,
            ],
        ];
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionIndex()
    {
        /** @var SignInForm $model */
        $model = new $this->model;
        $model->setScenario('signIn');
        $model->ONLY_ADMIN = true;

        if ($model->load(Yii::$app->getRequest()->post()) && $model->login()) {
            return $this->goHome();
        } else {
            return $this->render('index', [
                'model' => $model,
            ]);
        }
    }
}
