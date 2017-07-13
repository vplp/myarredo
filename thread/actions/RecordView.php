<?php

namespace thread\actions;

use Yii;
use yii\base\{
    Action, Exception
};
use yii\web\{
    NotFoundHttpException, Response
};

/**
 * Class RecordView
 *
 * @package thread\actions
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2016, VipDesign
 * @usage
 * public function actions() {
 *      return [
 *          ...
 *          'view' => [
 *              'class' => RecordView::class,
 *              'query' => Model::findOne(),
 *          ],
 *          ...
 *      ];
 * }
 */
class RecordView extends Action
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
    public $view = 'view';

    /**
     * Working model class name
     * Model should extends ActiveRecord
     *
     * @var string
     */
    public $modelClass = null;

    /**
     * Model method name for receiving data
     *
     * @var string
     */
    public $methodName = null;

    /**
     * Access checking
     *
     * @var bool
     */
    public $checkAccess = false;

    /**
     * Model
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
     * @param string | int $alias
     * @return string
     * @throws NotFoundHttpException
     */
    public function run($alias)
    {
        $ref = new \ReflectionMethod($this->model, $this->methodName);
        $model = $ref->invoke($this->model, $alias);
        if ($model === null) {
            throw new NotFoundHttpException;
        }
        if (Yii::$app->getRequest()->isAjax) {
            Yii::$app->getResponse()->format = Response::FORMAT_JSON;
            return $this->controller->renderPartial($this->view, [
                'model' => $model,
            ]);
        } else {
            $this->controller->layout = $this->layout;
            //SEO
            Yii::$app->metatag->registerModel($model);
            //SEO
            return $this->controller->render($this->view, [
                'model' => $model,
            ]);
        }
    }
}
