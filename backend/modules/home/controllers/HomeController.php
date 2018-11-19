<?php

namespace backend\modules\home\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\ErrorAction;
//
use thread\app\base\controllers\BackendController;

/**
 * Class HomeController
 *
 * @package backend\modules\home\controllers
 */
class HomeController extends BackendController
{
    public $layout = "@app/layouts/start";
    public $name = 'home';

    /**
     * @return array
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => ErrorAction::class
            ],
        ];
    }

    /**
     * @return \yii\web\Response
     */
    public function actionIndex()
    {
        return $this->redirect(Url::toRoute(['/page/page/list']));
    }

    /**
     * @param $action
     * @return bool
     */
    public function beforeAction($action)
    {
        if ($this->action->id == 'error') {
            $this->layout = Yii::$app->getUser()->isGuest ? '@app/layouts/nologin-error.php' : '@app/layouts/error.php';
        }

        return parent::beforeAction($action);
    }
}
