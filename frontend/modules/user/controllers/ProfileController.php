<?php

namespace frontend\modules\user\controllers;

use Yii;
use yii\{
    db\Exception, filters\AccessControl
};
//
use thread\actions\fileapi\{
    DeleteAction, UploadAction
};
//
use frontend\components\BaseController;
use frontend\modules\user\models\{
    Profile
};

/**
 * Class ProfileController
 *
 * @package frontend\modules\user\controllers
 */
class ProfileController extends BaseController
{
    protected $model = Profile::class;
    public $title = "Profile";
    public $defaultAction = 'index';

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
                        'actions' => ['index', 'update', 'fileupload', 'filedelete'],
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
     * @return array
     */
    public function actions()
    {
        return [
            'fileupload' => [
                'class' => UploadAction::class,
                'path' => $this->module->getAvatarUploadPath(Yii::$app->getUser()->getId())
            ],
            'filedelete' => [
                'class' => DeleteAction::class,
                'path' => $this->module->getAvatarUploadPath(Yii::$app->getUser()->getId())
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
            $transaction = $profile::getDb()->beginTransaction();
            try {
                $save = $profile->save();
                if ($save) {
                    $transaction->commit();
                    return $this->redirect(['index']);
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
}
