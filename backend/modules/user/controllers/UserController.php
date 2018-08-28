<?php

namespace backend\modules\user\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
//
use thread\app\base\controllers\BackendController;
use thread\modules\user\models\{
    form\CreateForm
};
use thread\actions\Update;
//
use backend\modules\user\models\{
    User, Profile, search\User as filterUserModel
};

/**
 * Class UserController
 *
 * @package backend\modules\user\controllers
 */
class UserController extends BackendController
{
    public $name = 'user';
    public $title = "User";
    protected $model = User::class;
    protected $filterModel = filterUserModel::class;

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
                        'roles' => ['admin', 'catalogEditor'],
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
                        return $_POST['save_and_exit'] ? $this->actionListLinkStatus : [
                            'update',
                            'id' => $this->action->getModel()->id
                        ];
                    }
                ],
                'intrash' => [
                    'redirect' => function () {
                        return $this->actionListLinkStatus;
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
        $this->layout = '@app/layouts/create';

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
                    return $this->redirect(($_POST['save_and_exit']) ? $this->actionListLinkStatus : [
                        'update',
                        'id' => $user->id
                    ]);
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
}
