<?php

namespace frontend\components;

use yii\helpers\Url;

/**
 * Class BaseController
 *
 * Базовый контроллер для пользовательской части проекта
 *
 * @package frontend\components
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
abstract class BaseController extends \yii\web\Controller
{
    /**
     * @var string
     */
    public $layout = "@app/layouts/main";

    /**
     * @var string
     */
    public $defaultAction = 'index';

    /**
     * @var array
     */
    public $breadcrumbs = [];

    /**
     * @param \yii\base\Action $action
     * @return bool|\yii\web\Response
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
