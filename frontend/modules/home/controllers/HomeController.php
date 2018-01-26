<?php

namespace frontend\modules\home\controllers;

use Yii;
use yii\web\ErrorAction;
use frontend\components\BaseController;

/**
 * Class HomeController
 *
 * @package frontend\modules\home\controllers
 */
class HomeController extends BaseController
{
    public $layout = "@app/layouts/start";

    /**
     * @return array
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => ErrorAction::class,
                'view' => 'error',
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        Yii::$app->metatag->render();

        return $this->render('index');
    }

    /**
     * @param $action
     * @return bool|\yii\web\Response
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        if ($action->id == 'error') {
            $this->layout = '/error';
        }

        return parent::beforeAction($action);
    }
}
