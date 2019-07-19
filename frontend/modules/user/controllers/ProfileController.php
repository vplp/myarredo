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
    Profile, ProfileLang
};

/**
 * Class ProfileController
 *
 * @package frontend\modules\user\controllers
 */
class ProfileController extends BaseController
{
    protected $model = Profile::class;
    protected $modelLang = ProfileLang::class;
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
        $model = new $this->model();

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
        /** @var $model Profile */
        /** @var $modelLang ProfileLang */
        /** @var $profile Profile */
        $model = new $this->model();
        $modelLang = new $this->modelLang();

        $profile = $model::findByUserId(Yii::$app->getUser()->id);
        $profileLang = $modelLang::find()->where(['rid' => Yii::$app->getUser()->id])->one();

        $profile->setScenario('ownEdit');

        if ($profileLang == null) {
            $profileLang = new ProfileLang([
                'rid' => $profile->id,
                'lang' => Yii::$app->language,
            ]);
        }

        $profileLang->setScenario('ownEdit');

        if ($profile->load(Yii::$app->getRequest()->post()) &&
            $profileLang->load(Yii::$app->getRequest()->post())
        ) {
            $transaction = $profile::getDb()->beginTransaction();
            try {
                $profile->city_id = ($profile->country_id == 4) ? 0 : $profile->city_id;

                $save = $profile->save();

                if ($save) {
                    $transactionLang = $profileLang::getDb()->beginTransaction();
                    try {
                        $saveLang = $profileLang->save();

                        if ($saveLang) {
                            $transactionLang->commit();
                        } else {
                            $transactionLang->rollBack();
                        }
                    } catch (Exception $e) {
                        $transactionLang->rollBack();
                    }

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
            'modelLang' => $profileLang,
        ]);
    }
}
