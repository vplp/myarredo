<?php

namespace frontend\modules\user\controllers;

use frontend\components\BaseController;
use Yii;
use yii\filters\AccessControl;
use frontend\modules\user\models\form\SignInForm;
use yii\helpers\Url;

/**
 * Class LoginController
 *
 * @package frontend\modules\user\controllers
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class LoginController extends BaseController
{

    protected $model = SignInForm::class;
    public $title = "Login";
    public $defaultAction = 'index';
    public $layout = "@app/layouts/nologin";

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
                        'actions' => ['index'],
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
     * @return string
     */
    public function actionIndex()
    {
        if (!\Yii::$app->getUser()->isGuest) {
            return $this->redirect(Url::toRoute('/home/home/index'));
        }

        /** @var SignInForm $model */
        $model = new $this->model;
        $model->setScenario('signIn');

        if ($model->load(Yii::$app->getRequest()->post()) && $model->login()) {
            return $this->redirect(Url::toRoute(['/home/home/index']));
        } else {
            return $this->render('index', [
                'model' => $model,
            ]);
        }
    }
}
