<?php

namespace backend\modules\user\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\captcha\CaptchaAction;
use thread\app\base\controllers\BackendController;
use thread\modules\user\models\form\SignInForm;

/**
 * Class LoginController
 *
 * @package admin\modules\user\controllers
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class LoginController extends BackendController
{
    public $name = 'login';
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
                        'actions' => ['index', 'captcha', 'validation'],
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
                'class' => CaptchaAction::class,
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
            Yii::$app->logbookAuth->send('login');
            return $this->goHome();
        } else {
            return $this->render('index', [
                'model' => $model,
            ]);
        }
    }
}
