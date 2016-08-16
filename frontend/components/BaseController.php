<?php
namespace frontend\components;

use yii\helpers\Url;

/**
 * Class BaseController
 *
 * @package frontend\controllers
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
abstract class BaseController extends \yii\web\Controller
{
    /**
     * Базовий layout
     * @var string
     */
    public $layout = "@app/layouts/main";

    /**
     * Назва базового методу дії
     * @var string
     */
    public $defaultAction = 'index';


    /**
     * // TODO:: ПЕРЕДАЛАТЬ
     *
     * @param \yii\base\Action $action
     * @return bool
     */
    public function beforeAction($action)
    {
        $searchCondition = \Yii::$app->getRequest()->get('search', null);

        if ($searchCondition) {
            return $this->redirect(Url::to(['/page/find/index', 'condition' => $searchCondition]));
        }


        return parent::beforeAction($action);
    }
}
