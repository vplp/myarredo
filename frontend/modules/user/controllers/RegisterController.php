<?php

namespace frontend\modules\user\controllers;

use Yii;
use yii\web\Response;
use yii\helpers\Url;
use yii\filters\AccessControl;
use frontend\components\BaseController;
use frontend\modules\user\models\User;
use frontend\modules\user\models\form\{
    RegisterForm, SignInForm
};
use frontend\modules\catalog\models\FactorySubdivision;

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
                        'actions' => [
                            'user',
                            'partner',
                            'factory',
                            'logistician',
                            'confirmation'
                        ],
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
                //return $this->redirect(Url::toRoute('/user/profile/index'));
                return $this->redirect(Yii::$app->session->get('referrer'));
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
     * @param $token
     * @return string|Response
     * @throws \Exception
     */
    public function actionConfirmation($token)
    {
        if (!Yii::$app->getUser()->getIsGuest()) {
            return $this->redirect(Url::toRoute('/home/home/index'));
        }

        /** @var RegisterForm $model */
        $model = new $this->model();

        $user = $model->confirmation($token);

        if ($user !== false) {
            $modelSignInForm = new SignInForm();

            $modelSignInForm->setScenario('signIn');
            $modelSignInForm->setAttributes($user->getAttributes());

            $modelSignInForm->login();

            Yii::$app->session->setFlash('success', Yii::$app->param->getByName('USER_CONFIRMATION_SUCCESS'));

            return $this->redirect(Url::toRoute('/user/login/index'));
        }

        return $this->render('confirmation', []);
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
                $modelUser = User::find()->email($model->email)->one();

                /** @var User $modelUser */
                /** send mail to admin */

                $title = 'Зарегистрирован новый партнер';

                $message = '<p>Название компании: ' . $modelUser->profile->getNameCompany() . '</p>' .
                    '<p>Имя: ' . $modelUser->profile->first_name . '</p>' .
                    '<p>Фамилия: ' . $modelUser->profile->last_name . '</p>' .
                    '<p>Страна: ' . $modelUser->profile->country->getTitle() . '</p>';

                if ($modelUser->profile->city) {
                    $message .= '<p>Город: ' . $modelUser->profile->city->getTitle() . '</p>';
                }

                $message .= '<p>Телефон: ' . $modelUser->profile->phone . '</p>' .
                    '<p>Е-майл: ' . $modelUser->email . '</p>';

                Yii::$app
                    ->mailer
                    ->compose(
                        'letter_notification_for_admin',
                        [
                            'title' => $title,
                            'message' => $message,
                            'url' => Url::home(true) . 'backend/user/user/update?id=' . $modelUser->id,
                        ]
                    )
                    ->setTo(\Yii::$app->params['mailer']['setTo'])
                    ->setSubject($title)
                    ->send();

                Yii::$app
                    ->mailer
                    ->compose(
                        'letter_about_registration',
                        [
                            'user' => $modelUser,
                            'password' => $model['password'],
                            'text' => Yii::$app->param->getByName('MAIL_REGISTRATION_TEXT_FOR_PARTNER')
                        ]
                    )
                    ->setTo($model->email)
                    ->setSubject(Yii::$app->name)
                    ->send();

                Yii::$app->session->setFlash('success', Yii::$app->param->getByName('USER_PERTNER_REG_CONGRATULATIONS'));

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

        $modelFactorySubdivision = new FactorySubdivision();
        $modelFactorySubdivision->setScenario('frontend');

        if ($model->load(Yii::$app->getRequest()->post()) && $model->validate()) {
            $status = $model->addFactory();

            if ($status === true) {
                $modelUser = User::find()->email($model->email)->one();

                /** @var User $modelUser */
                /** send mail to admin */

                $title = 'Зарегистрирована новая фабрика';

                $message = '<p>Название компании: ' . $modelUser->profile->getNameCompany() . '</p>' .
                    '<p>Имя: ' . $modelUser->profile->first_name . '</p>' .
                    '<p>Фамилия: ' . $modelUser->profile->last_name . '</p>' .
                    '<p>Страна: ' . $modelUser->profile->country->getTitle() . '</p>' .
                    '<p>Телефон: ' . $modelUser->profile->phone . '</p>' .
                    '<p>Е-майл: ' . $modelUser->email . '</p>';

                Yii::$app
                    ->mailer
                    ->compose(
                        'letter_notification_for_admin',
                        [
                            'title' => $title,
                            'message' => $message,
                            'url' => Url::home(true) . 'backend/user/user/update?id=' . $modelUser->id,
                        ]
                    )
                    ->setTo(\Yii::$app->params['mailer']['setTo'])
                    ->setSubject($title)
                    ->send();

                Yii::$app
                    ->mailer
                    ->compose(
                        'letter_about_registration',
                        [
                            'user' => $modelUser,
                            'password' => $model['password'],
                            'text' => Yii::$app->param->getByName('MAIL_REGISTRATION_TEXT_FOR_FACTORY')
                        ]
                    )
                    ->setTo($model->email)
                    ->setSubject(Yii::$app->name)
                    ->send();

                if ($modelUser->published == 1 && $modelUser->deleted == 0 && $model->getAutoLoginAfterRegister() === true && $model->login()) {
                    if (!Yii::$app->session->has("newUserFactory")) {
                        Yii::$app->session->set("newUserFactory", true);
                    }
                    //return $this->redirect(Url::toRoute('/user/profile/index'));
                    return $this->redirect(Yii::$app->request->referrer);
                }

                Yii::$app->session->setFlash('success', Yii::$app->param->getByName('USER_FACTORY_REG_CONGRATULATIONS'));

                return $this->redirect(Url::toRoute('/user/login/index'));
            }
        }

        return $this->render('register_factory', [
            'model' => $model,
            'modelFactorySubdivision' => $modelFactorySubdivision,
        ]);
    }

    /**
     * @return string|\yii\web\Response
     * @throws \Exception
     */
    public function actionLogistician()
    {
        if (!Yii::$app->getUser()->getIsGuest()) {
            return $this->redirect(Url::toRoute('/home/home/index'));
        }

        /** @var RegisterForm $model */
        $model = new $this->model();
        $model->setScenario('registerLogistician');

        if ($model->load(Yii::$app->getRequest()->post()) && $model->validate()) {
            $status = $model->addLogistician();

            if ($status === true) {
                $modelUser = User::find()->email($model->email)->one();

                /** send mail to admin */

                $title = 'Зарегистрировн новый логист';

                $message = $modelUser->profile->getNameCompany();

                Yii::$app
                    ->mailer
                    ->compose(
                        'letter_notification_for_admin',
                        [
                            'title' => $title,
                            'message' => $message,
                            'url' => Url::home(true) . 'backend/user/user/update?id=' . $modelUser->id,
                        ]
                    )
                    ->setTo(\Yii::$app->params['mailer']['setTo'])
                    ->setSubject($title)
                    ->send();

                Yii::$app
                    ->mailer
                    ->compose(
                        'letter_about_registration',
                        [
                            'user' => $modelUser,
                            'password' => $model['password'],
                            'text' => Yii::$app->param->getByName('MAIL_REGISTRATION_TEXT_FOR_PARTNER')
                        ]
                    )
                    ->setTo($model->email)
                    ->setSubject(Yii::$app->name)
                    ->send();

                Yii::$app->session->setFlash('success', Yii::$app->param->getByName('USER_PERTNER_REG_CONGRATULATIONS'));

                return $this->redirect(Url::toRoute('/user/login/index'));
            }
        }

        return $this->render('register_logistician', [
            'model' => $model,
        ]);
    }
}
