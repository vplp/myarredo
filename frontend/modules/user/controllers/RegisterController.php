<?php

namespace frontend\modules\user\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;
//
use frontend\components\BaseController;
use frontend\modules\user\models\User;
use frontend\modules\user\models\form\RegisterForm;


/**
 * Class RegisterController
 *
 * @package frontend\modules\user\controllers
 */
class RegisterController extends BaseController
{
    protected $model = RegisterForm::class;

    public $title = "Register";

    public $defaultAction = 'user';

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
                        'actions' => ['user', 'partner', 'factory'],
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
     * @return string|\yii\web\Response
     * @throws \Exception
     */
    public function actionUser()
    {
        if (!Yii::$app->getUser()->getIsGuest()) {
            return $this->redirect(Url::toRoute('/home/home/index'));
        }

        /** @var RegisterForm $model */
        $model = new $this->model();
        $model->setScenario('register');

        if ($model->load(Yii::$app->getRequest()->post()) && $model->validate()) {
            $status = $model->addUser();

            if ($status === true && $model->getAutoLoginAfterRegister() === true && $model->login()) {
                return $this->redirect(Url::toRoute('/user/profile/index'));
            }

            if ($status === true) {
                Yii::$app->getSession()->addFlash('login', Yii::t('user', 'add new members'));
                return $this->redirect(Url::toRoute('/user/login/index'));
            }
        }

        return $this->render('register_user', [
            'model' => $model,
        ]);
    }

    /**
     * @return string|\yii\web\Response
     * @throws \Exception
     */
    public function actionPartner()
    {
        if (!Yii::$app->getUser()->getIsGuest()) {
            return $this->redirect(Url::toRoute('/home/home/index'));
        }

        /** @var RegisterForm $model */
        $model = new $this->model();
        $model->setScenario('registerPartner');

        if ($model->load(Yii::$app->getRequest()->post()) && $model->validate()) {
            $status = $model->addPartner();

            if ($status === true) {
                $modelUser = User::findByEmail($model->email);

                Yii::$app
                    ->mailer
                    ->compose(
                        'letter_new_partner',
                        [
                            'message' => 'Зарегистрирован новый партнер',
                            'model' => $model,
                            'modelUser' => $modelUser,
                        ]
                    )
                    ->setTo(Yii::$app->params['mailer']['setTo'])
                    ->setSubject('Зарегистрирован новый партнер')
                    ->send();

                Yii::$app
                    ->mailer
                    ->compose(
                        'letter_about_registration',
                        [
                            'user' => $model,
                            'password' => $model['password'],
                            'text' => Yii::$app->param->getByName('MAIL_REGISTRATION_TEXT_FOR_PARTNER')
                        ]
                    )
                    ->setTo($model->email)
                    ->setSubject(Yii::$app->name)
                    ->send();

                //Yii::$app->getSession()->addFlash('success', Yii::$app->param->getByName('USER_FACTORY_REG_MESSAGE'));
            }

            if ($status === true && $model->getAutoLoginAfterRegister() === true && $model->login()) {
                return $this->redirect(Url::toRoute('/user/profile/index'));
            }

            if ($status === true) {
                Yii::$app->getSession()->addFlash('login', Yii::t('user', 'add new members'));
                return $this->redirect(Url::toRoute('/user/login/index'));
            }
        }

        return $this->render('register_partner', [
            'model' => $model,
        ]);
    }

    /**
     * @return string|\yii\web\Response
     * @throws \Exception
     */
    public function actionFactory()
    {
        if (!Yii::$app->getUser()->getIsGuest()) {
            return $this->redirect(Url::toRoute('/home/home/index'));
        }

        /** @var RegisterForm $model */
        $model = new $this->model();
        $model->setScenario('registerFactory');

        if ($model->load(Yii::$app->getRequest()->post()) && $model->validate()) {
            $status = $model->addFactory();

            if ($status === true) {
                $modelUser = User::findByEmail($model->email);

                /** send mail to admin */
                Yii::$app
                    ->mailer
                    ->compose(
                        'letter_new_factory',
                        [
                            'message' => 'Зарегистрирована новая фабрика',
                            'model' => $model,
                            'modelUser' => $modelUser,
                        ]
                    )
                    ->setTo(Yii::$app->params['mailer']['setTo'])
                    ->setSubject('Зарегистрирована новая фабрика')
                    ->send();

                Yii::$app
                    ->mailer
                    ->compose(
                        'letter_about_registration',
                        [
                            'user' => $model,
                            'password' => $model['password'],
                            'text' => Yii::$app->param->getByName('MAIL_REGISTRATION_TEXT_FOR_FACTORY')
                        ]
                    )
                    ->setTo($model->email)
                    ->setSubject(Yii::$app->name)
                    ->send();

                if ($status === true && $model->getAutoLoginAfterRegister() === true && $model->login()) {
                    if (!Yii::$app->session->has("newUserFactory")) {
                        Yii::$app->session->set("newUserFactory", true);
                    }

                    return $this->redirect(Url::toRoute('/user/profile/index'));
                }

                if ($status === true) {
                    Yii::$app->getSession()->addFlash('login', Yii::t('user', 'add new members'));
                    return $this->redirect(Url::toRoute('/user/login/index'));
                }
            }
        }

        return $this->render('register_factory', [
            'model' => $model,
        ]);
    }
}
