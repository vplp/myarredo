<?php
namespace backend\modules\user\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\filters\AccessControl;
use yii\web\{
    BadRequestHttpException, NotFoundHttpException
};
//
use thread\app\base\controllers\BackendController;
//
use thread\modules\user\models\form\{
    ChangePassword, PasswordResetRequestForm
};
//
use backend\modules\user\models\{
    User
};
//
use common\modules\user\models\form\ResetPasswordForm;

/**
 * Class PasswordController
 *
 * @package admin\modules\user\controllers
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class PasswordController extends BackendController
{
    public $name = 'password';
    public $title = "User Password";
    public $label = "User Password";
    protected $model = User::class;
    public $actionListLinkStatus = ['/user/user/list'];

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
                        'actions' => ['request-reset', 'reset'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['validation', 'change'],
                        'roles' => ['admin']
                    ],
                    [
                        'allow' => false,
                    ],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        return true;
    }

    /**
     *
     * @return array
     */
    public function actions()
    {
        return [];
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     * @throws \Exception
     */
    public function actionChange($id)
    {

        $user = User::findIdentity($id);
        if ($user === null) {
            throw new NotFoundHttpException;
        }

        $this->label = Yii::t('user', 'Password change') . ' : ' . $user['username'];

        $model = new ChangePassword();
        $model->setScenario('adminPasswordChange');
        $model['username'] = $user['username'];
        $model['email'] = $user['email'];

        if ($model->load(Yii::$app->getRequest()->post()) && $model->validate()) {

            if ($user !== null) {
                $user->setScenario('passwordChange');
                $user->setPassword($model['password']);

                $transaction = $user::getDb()->beginTransaction();
                try {
                    $save = $user->save();
                    if ($save) {
                        $transaction->commit();
                        if (Yii::$app->getRequest()->post('save_and_exit')) {
                            return $this->redirect($this->actionListLinkStatus);
                        } else {
                            Yii::$app->session->addFlash('success', Yii::t('user', 'Password changed'));
                        }
                    }
                } catch (\Exception $e) {
                    $transaction->rollBack();
                    throw new \Exception($e);
                }
            }
        }

        foreach ($model->getErrors() as $attribute => $errors) {
            Yii::$app->session->setFlash('error', $errors);
        }

        return $this->render('change', [
            'model' => $model,
            'user' => $user
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

        if ($model->load(Yii::$app->getRequest()->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', Yii::t('user', 'Check your email for further instructions.'));
                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', Yii::t('user', 'Sorry, we are unable to reset password for email provided.'));
            }
        }

        $this->layout = '@app/layouts/nologin';

        return $this->render('requestResetToken', [
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

        if ($model->load(Yii::$app->getRequest()->post()) && $model->validate() && $model->setPassword()) {
            Yii::$app->session->setFlash('success', Yii::t('user', 'New password was saved.'));
            return $this->goHome();
        }

        $this->layout = '@app/layouts/nologin';

        return $this->render('reset', [
            'model' => $model,
        ]);
    }
}
