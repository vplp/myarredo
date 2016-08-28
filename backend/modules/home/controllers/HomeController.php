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
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class HomeController extends BackendController
{
    public $layout = "@app/layouts/start";
    public $name = 'home';

    /**
     *
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
     *
     * @return string
     */
    public function actionIndex()
    {
//        return $this->render('index');
        return $this->redirect(Url::toRoute(['/page/page/list']));
    }

    /**
     * @param $action
     * @return mixed
     */
    public function beforeAction($action)
    {
        if ($this->action->id == 'error') {
            $this->layout = Yii::$app->getUser()->isGuest ? '@app/layouts/nologin-error.php' : '@app/layouts/error.php';
        }

        return parent::beforeAction($action);
    }

}
