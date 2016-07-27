<?php

namespace thread\actions;

use Yii;
use yii\base\Action;
use yii\web\Response;
use yii\base\Exception;

/**
 * Class ListModel
 *
 * @package thread\actions
 * @author FilamentV <vortex.filament@gmail.com>
 * @author Roman Gonchar <roman.gonchar92@gmail.com>
 * @copyright (c) 2016, VipDesign
 * @usage
 * public function actions() {
 *      return [
 *          ...
 *          'list' => [
 *              'class' => DataProviderList::class,
 *              'modelClass' => Model::class,
 *              'methodName' => 'search',
 *          ],
 *          ...
 *      ];
 * }
 *
 */
class ListModel extends Action
{

    /**
     * Base layout
     *
     * @var string
     */
    public $layout = '@app/layouts/base';

    /**
     * Base view
     *
     * @var string
     */
    public $view = 'list';

    /**
     * Base working model class name
     * Model should extends ActiveRecord
     *
     * @var string
     */
    public $modelClass = null;

    /**
     * Base model method name for receiving data
     *
     * @var string
     */
    public $methodName = 'search';

    /**
     * Access checking
     *
     * @var bool
     */
    public $checkAccess = false;

    /**
     * Working model
     *
     * @var \yii\db\ActiveRecord
     */
    protected $model = null;

    /**
     * Init action
     *
     * @inheritdoc
     * @throws Exception
     */
    public function init()
    {
        if ($this->modelClass === null) {
            throw new Exception(__CLASS__ . '::$modelClass must be set.');
        }
        $this->model = new $this->modelClass;
        if ($this->model === null) {
            throw new Exception($this->modelClass . ' must be exists.');
        }
        if (!method_exists($this->model, $this->methodName)) {
            throw new Exception($this->modelClass . '::' . $this->methodName . ' must be exists.');
        }
    }

    /**
     * Run action
     *
     * @return string
     */
    public function run()
    {
        $this->controller->layout = $this->layout;
        if (Yii::$app->getRequest()->isAjax) {
            Yii::$app->getResponse()->format = Response::FORMAT_JSON;
            return $this->controller->renderPartial($this->view, [
                'model' => $this->model,
            ]);
        } else {
            $this->controller->layout = $this->layout;
            return $this->controller->render($this->view, [
                'model' => $this->model,
            ]);
        }
    }
}
