<?php

namespace frontend\modules\user\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Response;
use yii\widgets\ActiveForm;
//
use frontend\components\BaseController;
use frontend\modules\user\models\form\SignInForm;

/**
 * Class LoginController
 *
 * @package frontend\modules\user\controllers
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
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

    /**
     * Перевірка валідації моделі(-ей)
     * Має бути встановдений у моделі scenario 'backend'
     * @return mixed
     */
    public function actionValidation()
    {
        /** @var Model $model */
        $model = new $this->model;
        $model->setScenario('signIn');
        $model->load(Yii::$app->getRequest()->post());

        Yii::$app->getResponse()->format = Response::FORMAT_JSON;

        return ActiveForm::validate($model);
    }
}
