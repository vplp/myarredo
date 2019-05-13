<?php

namespace frontend\modules\user\controllers;

use Yii;
use yii\{helpers\Url, web\BadRequestHttpException, base\InvalidParamException, db\Exception, filters\AccessControl};
//
use frontend\components\BaseController;
use frontend\modules\user\models\form\{
    PasswordResetRequestForm, ResetPasswordForm, ChangePassword
};
use frontend\modules\user\models\{
    Profile, User
};

/**
 * Class PasswordController
 *
 * @package frontend\modules\user\controllers
 */
class PasswordController extends BaseController
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
                        'actions' => ['change'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['request-reset', 'reset'],
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
     * @throws \Throwable
     * @throws \yii\base\Exception
     */
    public function actionChange()
    {
        /**
         * @var $userIdentity User
         */
        $userIdentity = Yii::$app->user->identity;

        $model = new ChangePassword();
        $model->setScenario('passwordChange');
        $model->username = $userIdentity->username;
        $model->email = $userIdentity->email;

        if ($model->load(Yii::$app->getRequest()->post()) && $model->validate()) {
            $user = User::findIdentity(Yii::$app->getUser()->id);
            if ($user != null) {
                $user->setScenario('passwordChange');
                $user->setPassword($model->password);
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
    public function actionRequestReset()
    {
        $model = new PasswordResetRequestForm();
        $model->setScenario('remind');
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->generateResetToken()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Проверьте свою электронную почту для получения дальнейших инструкций.');
                return $this->redirect(Url::toRoute('/home/home/index'));
            } else {
                Yii::$app->session->setFlash('error', 'Извините, мы не можем сбросить пароль для отправки по электронной почте.');
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
    public function actionReset($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        $model->setScenario('setPassword');

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->setPassword()) {
            Yii::$app->session->setFlash('success', Yii::t('app', 'Password changed'));
            return $this->redirect(Url::toRoute('/home/home/index'));
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
