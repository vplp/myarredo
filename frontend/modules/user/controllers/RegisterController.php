<?php

namespace frontend\modules\user\controllers;

use frontend\components\BaseController;
use Yii;
use yii\filters\AccessControl;
use frontend\modules\user\models\form\RegisterForm;
use yii\helpers\Url;

/**
 * Class LoginController
 *
 * @package frontend\modules\user\controllers
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class RegisterController extends BaseController
{

    protected $model = RegisterForm::class;
    public $title = "Login";
    public $defaultAction = 'index';
    public $layout = "@app/layouts/nologin";

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
     *
     * @return string
     */
    public function actionIndex()
    {
        if (!\Yii::$app->getUser()->getIsGuest()) {
            return $this->redirect(Url::toRoute('/home/home/index'));
        }
        /** @var RegisterForm $model */
        $model = new $this->model;
        $model->setScenario('register');
        if ($model->load(Yii::$app->getRequest()->post()) && $model->validate()) {
            $status = $model->addUser();
            if ($status === true && $model->getAutoLoginAfterRegister() === true && $model->login()) {
                return $this->redirect(Url::toRoute('/home/home/index'));
            }
            if ($status === true) {
                Yii::$app->getSession()->addFlash('login', Yii::t('user', 'add new members'));
                return $this->redirect(Url::toRoute('/user/login'));
            }
        }
        return $this->render('index', [
            'model' => $model,
        ]);
    }
}
