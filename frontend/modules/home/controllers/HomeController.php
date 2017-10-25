<?php

namespace frontend\modules\home\controllers;

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
        return $this->render('index');
    }

    /**
     * @param \yii\base\Action $action
     * @return bool|\yii\web\Response
     */
    public function beforeAction($action)
    {
        if ($action->id == 'error') {
            $this->layout = '/error';
        }

        return parent::beforeAction($action);
    }
}
