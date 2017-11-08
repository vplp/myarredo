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
                        'actions' => [
                            'published',
                            'create',
                            'update',
                            'list',
                            'validation',
                            'trash',
                            //'import-users'
                        ],
                        'roles' => ['admin'],
                        'matchCallback' => function ($rule, $action) {
                            return (Yii::$app->getUser()->id === 1) ? true : false;
                        }
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'outtrash',
                            'intrash'
                        ],
                        'roles' => ['admin'],
                        'matchCallback' => function ($rule, $action) {
                            return (Yii::$app->getUser()->id === 1) ? true : false;
                        }
                    ],
                    [
                        'allow' => true,
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
//                'list' => [
//                    'layout' => 'list-user',
//                ],
                'update' => [
                    'class' => Update::class,
                    'redirect' => function () {
                        return $_POST['save_and_exit'] ? $this->actionListLinkStatus : [
                            'update',
                            'id' => $this->action->getModel()->id
                        ];
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

    public function actionImportUsers()
    {
        $userGroups = [
            'admin' => 1,
            'editor' => 2,
            'editorurl' => 2,
            'factory' => 3,
            'super_manager' => 2,
            'super_partner' => 4,
            'super_visitor' => 2,
            'visitor' => 2
        ];

        $rows = (new \yii\db\Query())
            ->from('c1myarredo2017_old.user')
            ->leftJoin('c1myarredo2017_old.auth_assignment', 'auth_assignment.userid = user.login')
            ->leftJoin('c1myarredo2017_old.user_data', 'user_data.uid = user.id')
            ->leftJoin('c1myarredo2017_old.user_lang', 'user_lang.rid = user.id')
            ->all();

        User::deleteAll();
        Yii::$app->db->createCommand('ALTER TABLE ' . User::tableName() . ' AUTO_INCREMENT = 1')->execute();
        Yii::$app->db->createCommand('ALTER TABLE ' . Profile::tableName() . ' AUTO_INCREMENT = 1')->execute();


        Yii::$app->db->createCommand('DELETE FROM fv_auth_assignment')->execute();

        foreach ($rows as $row) {

            $user = new User();
            $user->setScenario('userCreate');

            $user->id = $row['id'];

            $user->group_id = ($row['id'] == 1)
                ? 1
                : $userGroups[$row['itemname']];

            $user->username = ($row['id'] == 1)
                ? 'admin'
                : $row['login'];

            $user->email = $row['email'];

            $user->password_hash = ($row['id'] == 1)
                ? '$2y$13$XCcJ9zM6YbClmQYmQd9l2.kM4cadZA5GQTajDkHsgml.IbogBKxdK'
                : $row['password'];

            $user->auth_key = '';
            $user->published = $row['enabled'];
            $user->deleted = $row['deleted'];

            /** @var PDO $transaction */
            $transaction = $user::getDb()->beginTransaction();
            try {
                $user->save();

                $profile = new Profile();
                $profile->setScenario('basicCreate');

                $profile->id = $user->id;
                $profile->user_id = $user->id;
                $profile->first_name = $row['name'];
                $profile->last_name = $row['surname'];
                $profile->country_id = $row['country_id'] ?? 0;
                $profile->city_id = $row['city_id'] ?? 0;
                $profile->phone = $row['telephone'];
                $profile->address = $row['address'];
                $profile->name_company = $row['name_company'];
                $profile->website = $row['website'];
                $profile->exp_with_italian = $row['exp_with_italian'];
                $profile->delivery_to_other_cities = $row['delivery_to_other_cities'] ?? 0;
                $profile->latitude = $row['latitude'] ?? 0;
                $profile->longitude = $row['longitude'] ?? 0;

                $profile->save();

                $transaction->commit();
            } catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
            }
        }
    }
}
