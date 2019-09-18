<?php

namespace frontend\modules\home\controllers;

use Yii;
use yii\web\ErrorAction;
//
use frontend\components\BaseController;
use frontend\themes\myarredo\assets\AppAsset;

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
        Yii::$app->metatag
            ->render()
            ->setImageUrl(Yii::$app->request->hostInfo . AppAsset::register(Yii::$app->view)->baseUrl . 'img/logo.svg')
            ->renderGraph();

        return $this->render('index');
    }

    /**
     * @param $action
     * @return bool
     */
    public function beforeAction($action)
    {
        if ($action->id == 'error') {
            $this->layout = '/error';
        }

        return parent::beforeAction($action);
    }
}
