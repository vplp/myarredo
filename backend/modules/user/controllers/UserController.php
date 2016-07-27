<?php
namespace backend\modules\user\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\db\mssql\PDO;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
//
use thread\app\base\controllers\BackendController;
use thread\modules\user\models\Profile;
use thread\actions\Update;
//
use common\modules\user\models\form\{
    ChangePassword, CreateForm, PasswordResetRequestForm, ResetPasswordForm
};
//
use backend\modules\user\models\search\User;



/**
 * Class UserController
 *
 * @package admin\modules\user\controllers
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class UserController extends BackendController
{

    public $label = "User";
    public $title = "User";
    protected $model = User::class;

    public function behaviors()
    {
        return [
            'AccessControl' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['error'],
                        'roles' => ['?', '@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['request-password-reset', 'reset-password'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create', 'update', 'list', 'validation', 'password-change'],
                        'roles' => ['admin']
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
     * @return array
     */
    public function actions()
    {

        $action = parent::actions();
        unset($action['create']);

        return ArrayHelper::merge(
            $action,
            [
                'update' => [
                    'class' => Update::class,
                    'redirect' => function () {
                        return $_POST['save_and_exit'] ? $this->actionListLinkStatus : ['update', 'id' => $this->action->getModel()->id];
                    }
                ],
            ]
        );
    }

    /**
     * @return string|\yii\web\Response
     * @throws \Exception
     */
    public function actionCreate()
    {
        $this->layout = '@app/layouts/crud';
        $this->label = Yii::t('app', 'Create');

        $model = new CreateForm();
        $model->setScenario('userCreate');
        
        if ($model->load(Yii::$app->getRequest()->post()) && $model->validate()) {
            $user = new User([
                'group_id' => $model->group_id,
                'username' => $model->username,
                'email' => $model->email,
                'published' => $model->published,
                'scenario' => 'userCreate',
            ]);
            $user->setPassword($model->password)->generateAuthKey();

            /** @var PDO $transaction */
            $transaction = $user::getDb()->beginTransaction();
            try {
                $save = $user->save();

                if ($save) {
                    $profile = new Profile([
                        'user_id' => $user->id,
                        'scenario' => 'basicCreate',
                    ]);

                    $profile->save();
                }

                if ($save) {
                    $transaction->commit();
                    return $this->redirect(($_POST['save_and_exit']) ? $this->actionListLinkStatus : ['update', 'id' => $user->id]);
                } else {
                    $transaction->rollBack();
                }
            } catch (\Exception $e) {
                $transaction->rollBack();
                throw new \Exception($e);
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     * @throws \Exception
     */
    public function actionPasswordChange($id)
    {

        $this->layout = '@app/layouts/crud';

        $user = User::findIdentity($id);
        if ($user === null) {
            throw new NotFoundHttpException;
        }

        $this->label = Yii::t('app', 'Password change') . ' : ' . $user->username;

        $model = new ChangePassword();
        $model->setScenario('adminPasswordChange');
        $model->username = $user->username;
        $model->email = $user->email;

        if ($model->load(Yii::$app->getRequest()->post()) && $model->validate()) {
            if ($user !== null) {
                $user->setScenario('passwordChange');
                $user->setPassword($model->password);

                /** @var PDO $transaction */
                $transaction = $user::getDb()->beginTransaction();
                try {
                    $save = $user->save();
                    if ($save) {
                        $transaction->commit();
                        if (Yii::$app->getRequest()->post('save_and_exit')) {
                            return $this->redirect($this->actionListLinkStatus);
                        } else {
                            $model->addFlash(Yii::t('app', 'Password changed'));
                        }
                    } else {
                        $transaction->rollBack();
                    };
                } catch (\Exception $e) {
                    $transaction->rollBack();
                    throw new \Exception($e);
                }
            }
        }
        return $this->render('passwordChange', [
            'model' => $model,
        ]);
    }

    public function actionView($id)
    {
        $this->layout = '@app/layouts/crud';
        $this->label = Yii::t('app', 'View');
        $model = User::findIdentity($id);
        return $this->render('_view_user', [
            'model' => $model,
            'backLink' => Yii::$app->request->referrer
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
        $this->layout = '@app/layouts/nologin';
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
        $this->layout = '@app/layouts/nologin';
        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
