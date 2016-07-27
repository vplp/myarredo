<?php

namespace frontend\modules\home\controllers;

use Yii;

/**
 * Class HomeController
 *
 * @package frontend\modules\home\controllers
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2014, Thread
 */
class HomeController extends \frontend\components\BaseController
{

    public $layout = "@app/layouts/start";

    /**
     *
     * @return array
     */
    public function actions() {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
                'view' => 'error',
            ],
        ];
    }

    /**
     *
     * @return string
     */
    public function actionIndex() {

//        if (!empty($_GET)) {
//            $this->redirect(['/'], 301);
//        }

        return $this->render('index');
    }

    /**
     *
     * @param type $action
     * @return boollean
     */
    public function beforeAction($action) {

        if ($action->id == 'error') {
            $this->layout = (Yii::$app->getUser()->id !== NULL) ? '/error' : '/error';
        }

        return parent::beforeAction($action);
    }

}
