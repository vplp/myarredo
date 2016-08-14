<?php

namespace backend\modules\user\controllers;

use Yii;
use yii\db\Exception;
use yii\web\NotFoundHttpException;
//
use thread\app\base\controllers\BackendController;
use thread\actions\Update;
//
use thread\modules\user\models\form\ChangePassword;
//
use backend\modules\user\models\{
    User, Profile
};

/**
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class ProfileController extends BackendController
{

    public $label = "Profile";
    public $title = "Profile";
    protected $model = Profile::class;
    public $defaultAction = 'list';
    public $actionListLinkStatus = "list";

    /**
     *
     * @return array
     */
    public function actions()
    {
        return [
            'update' => [
                'class' => Update::class,
                'modelClass' => $this->model,
                'redirect' => function () {
                    return $_POST['save_and_exit'] ? ['/user/user/list'] : ['update', 'id' => $this->action->getModel()->id];
                }
            ]
        ];
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionPasswordChange($id)
    {
        $user = User::findIdentity($id);
        if ($user === null) {
            throw new NotFoundHttpException;
        }

        $this->label = Yii::t('app', 'Change password') . ' : ' . $user->username;

        $model = new ChangePassword();
        $model->setScenario('passwordChange');
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
                        $model->addFlash(Yii::t('app', 'password changed'));
                        $transaction->commit();

                        return $_POST['save_and_exit'] ? $this->redirect(['update', 'id' => $user->profile->id]) : $this->redirect(['password-change', 'id' => $user->profile->id]);
                    } else {
                        $transaction->rollBack();
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }
        return $this->render('passwordchange', [
            'model' => $model,
        ]);
    }
}
