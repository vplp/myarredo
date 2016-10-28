<?php

namespace frontend\modules\user\controllers;

use Yii;
use yii\web\BadRequestHttpException;
use yii\base\InvalidParamException;
use yii\db\Exception;
use yii\db\mssql\PDO;
use yii\filters\AccessControl;
//
use frontend\components\BaseController;
use frontend\modules\user\models\form\{
    PasswordResetRequestForm, ResetPasswordForm, ChangePassword
};
use frontend\modules\user\models\{
    Profile, User
};


/**
 * Class ProfileController
 *
 * @package frontend\modules\user\controllers
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class ProfileController extends BaseController
{

    protected $model = Profile::class;
    public $title = "Profile";
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
                        'actions' => ['index', 'update', 'password-change'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['request-password-reset', 'reset-password'],
                        'roles' => ['?']
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
        /** @var Profile $model */
        $model = new $this->model;
        $model->setScenario('frontend');
        $user = $model::findByUserId(Yii::$app->getUser()->id);

        return $this->render('index', [
            'model' => $user,
        ]);
    }

    /**
     * @return string
     */
    public function actionUpdate()
    {
        /** @var Profile $model */
        $model = new $this->model;
        $model->setScenario('ownEdit');
        $profile = $model::findByUserId(Yii::$app->getUser()->id);
        $profile->setScenario('ownEdit');
        if ($profile->load(Yii::$app->getRequest()->post())) {
            /** @var PDO $transaction */
            $transaction = $profile::getDb()->beginTransaction();
            try {
                $save = $profile->save();
                if ($save) {
                    $transaction->commit();
                    return $this->redirect('index');
                } else {
                    $transaction->rollBack();
                }
            } catch (Exception $e) {
                $transaction->rollBack();
            }
        }
        return $this->render('_form', [
            'model' => $profile,
        ]);
    }

    /**
     * @return string
     */
    public function actionPasswordChange()
    {
        $model = new ChangePassword();
        $model->setScenario('passwordChange');
        $model->username = Yii::$app->getUser()->getIdentity()->username;
        $model->email = Yii::$app->getUser()->getIdentity()->email;

        if ($model->load(Yii::$app->getRequest()->post()) && $model->validate()) {
            $user = User::findIdentity(Yii::$app->getUser()->id);
            if ($user !== null) {
                $user->setScenario('passwordChange');
                $user->setPassword($model->password);
                /** @var PDO $transaction */
                $transaction = $user::getDb()->beginTransaction();
                try {
                    $save = $user->save();
                    if ($save) {
                        $transaction->commit();
                        $model->addFlash(Yii::t('app', 'Password changed'));
                    } else {
                        $transaction->rollBack();
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }
        return $this->render('passwordChange', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        $model->setScenario('remind');
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }
        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        $model->setScenario('setPassword');
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->setPassword()) {
            Yii::$app->session->setFlash('success', 'New password was saved.');
            return $this->goHome();
        }
        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
