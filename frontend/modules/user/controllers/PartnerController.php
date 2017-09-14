<?php

namespace frontend\modules\user\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;
//
use frontend\components\BaseController;
use frontend\modules\user\models\form\RegisterForm;

/**
 * Class PartnerController
 *
 * @package frontend\modules\user\controllers
 */
class PartnerController extends BaseController
{
    protected $model = RegisterForm::class;
    public $title = "Partner";
    public $defaultAction = 'register';

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
                        'actions' => ['register'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
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
     * @return string|\yii\web\Response
     */
    public function actionRegister()
    {
        if (!\Yii::$app->getUser()->getIsGuest()) {
            return $this->redirect(Url::toRoute('/home/home/index'));
        }

        /** @var RegisterForm $model */
        $model = new $this->model;
        $model->setScenario('registerPartner');

        if ($model->load(Yii::$app->getRequest()->post()) && $model->validate()) {
            $status = $model->addPartner();
            if ($status === true && $model->getAutoLoginAfterRegister() === true && $model->login()) {
                return $this->redirect(Url::toRoute('/user/profile/index'));
            }
            if ($status === true) {
                Yii::$app->getSession()->addFlash('login', Yii::t('user', 'add new members'));
                return $this->redirect(Url::toRoute('/user/login/index'));
            }
        }

        return $this->render('register', [
            'model' => $model,
        ]);
    }
}
