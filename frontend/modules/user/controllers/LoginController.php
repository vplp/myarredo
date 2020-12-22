<?php

namespace frontend\modules\user\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Response;
use yii\widgets\ActiveForm;
use frontend\components\BaseController;
use frontend\modules\user\models\form\SignInForm;

/**
 * Class LoginController
 *
 * @package frontend\modules\user\controllers
 */
class LoginController extends BaseController
{
    public $title = "Login";
    public $defaultAction = 'index';
    public $layout = "@app/layouts/nologin";
    protected $model = SignInForm::class;

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
                        'actions' => ['index', 'validation'],
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
     * @return string|Response
     * @throws \Exception
     * @throws \Throwable
     */
    public function actionIndex()
    {
        if (!Yii::$app->getUser()->isGuest) {
            Yii::$app->response->redirect(Url::toRoute('/user/profile/index'));
            yii::$app->end();
        }

        /** @var SignInForm $model */
        $model = new $this->model();
        $model->setScenario('signIn');

        if ($model->load(Yii::$app->getRequest()->post()) && $model->login()) {
            $user = Yii::$app->user->identity;
            Yii::$app->logbookAuth->send('login');
            \Yii::$app->params['themes']['language'] = $user->profile->preferred_language;
            Yii::$app->language = $user->profile->preferred_language;

            $session = Yii::$app->session;

            if ($session->has('redirectToOrders')) {
                Yii::$app->response->redirect($session->get('redirectToOrders'));
                yii::$app->end();
            }

            if (strpos($session->get('referrer'), 'user/login') === false) {
                Yii::$app->response->redirect($session->get('referrer'));
                yii::$app->end();
            } else {
                Yii::$app->response->redirect(Url::toRoute('/user/profile/index'));
                yii::$app->end();
            }
        } else {
            return $this->render('index', [
                'model' => $model,
            ]);
        }
    }

    /**
     * @return array
     */
    public function actionValidation()
    {
        /** @var Model $model */
        $model = new $this->model();
        $model->setScenario('signIn');
        $model->load(Yii::$app->getRequest()->post());

        Yii::$app->getResponse()->format = Response::FORMAT_JSON;

        return ActiveForm::validate($model);
    }
}
