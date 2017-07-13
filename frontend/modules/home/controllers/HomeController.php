<?php

namespace frontend\modules\home\controllers;

use Yii;
use yii\web\ErrorAction;

/**
 * Class HomeController
 *
 * @package frontend\modules\home\controllers
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class HomeController extends \frontend\components\BaseController
{

    public $layout = "@app/layouts/start";

    /**
     *
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
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     *
     * @param type $action
     * @return boollean
     */
    public function beforeAction($action)
    {

        if ($action->id == 'error') {
            $this->layout = '/error';
        }

        return parent::beforeAction($action);
    }

}
