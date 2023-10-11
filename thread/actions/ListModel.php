<?php

namespace thread\actions;

use Yii;
use yii\base\{
    Action, Exception
};
use yii\web\Response;
use yii\db\ActiveRecord;
use yii\log\Logger;

/**
 * Class ListModel
 *
 * @package thread\actions
 * @author FilamentV <vortex.filament@gmail.com>
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
     * @var null|\Closure|\yii\db\ActiveRecord
     */
    public $filterModel = null;

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
                'filter' => $this->getFilter()
            ]);
        } else {
            $this->controller->layout = $this->layout;
            return $this->controller->render($this->view, [
                'model' => $this->model,
                'filter' => $this->getFilter()
            ]);
        }
    }

    /**
     * @return null|\Closure|\yii\db\ActiveRecord
     */
    public function getFilter()
    {
        $filter = $this->filterModel;

        if ($this->filterModel == null) {
            return null;
        }
        if ($filter instanceof \Closure) {
            return $filter();
        } else {

            try {
                $filter = new $this->filterModel;

                if ($filter instanceof ActiveRecord) {
                    $filter->load(Yii::$app->getRequest()->queryParams);
                    return $filter;
                }

            } catch (\Exception $e) {
                Yii::getLogger()->log($e->getMessage(), Logger::LEVEL_ERROR);
                return null;
            }
        }
    }
}
