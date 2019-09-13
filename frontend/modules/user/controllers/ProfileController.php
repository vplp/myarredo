<?php

namespace frontend\modules\user\controllers;

use Yii;
use yii\{
    db\Exception, filters\AccessControl
};
//
use common\actions\upload\{
    DeleteAction, UploadAction
};
//
use frontend\modules\catalog\models\Factory;
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
        if (!Yii::$app->getUser()->isGuest && Yii::$app->user->identity->group->role == 'factory') {
            $module = Yii::$app->getModule('catalog');
            $path = $module->getFactoryUploadPath();
        } else {
            $path = $this->module->getAvatarUploadPath(Yii::$app->getUser()->getId());
        }
        return [
            'fileupload' => [
                'class' => UploadAction::class,
                'path' => $path
            ],
            'filedelete' => [
                'class' => DeleteAction::class,
                'path' => $path
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
     * @return string|\yii\web\Response
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
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

        if ($profileLang == null) {
            $profileLang = new ProfileLang([
                'rid' => $profile->id,
                'lang' => Yii::$app->language,
            ]);
        }

        $profile->setScenario('ownEdit');
        $profileLang->setScenario('ownEdit');

        /**
         * factory
         */
        $modelFactory = null;

        if (Yii::$app->user->identity->group->role == 'factory' && Yii::$app->user->identity->profile->factory_id) {
            $modelFactory = Factory::findById(Yii::$app->user->identity->profile->factory_id);
            /** @var $modelFactory Factory */
            if ($modelFactory != null) {
                $modelFactory->setScenario('setImages');

                if ($modelFactory->load(Yii::$app->getRequest()->post())) {
                    $transaction = $modelFactory::getDb()->beginTransaction();
                    try {
                        $save = $modelFactory->save();
                        if ($save) {
                            $transaction->commit();
                        } else {
                            $transaction->rollBack();
                        }
                    } catch (Exception $e) {
                        $transaction->rollBack();
                    }
                }
            }
        }

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
            'modelFactory' => $modelFactory,
        ]);
    }
}
