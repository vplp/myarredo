<?php

namespace thread\actions;

use Yii;
use Closure;
use yii\base\{
    Action, Model
};
use thread\modules\sys\modules\logbook\models\Logbook;
use yii\helpers\Url;
use yii\log\Logger;

/**
 * Class ActionCRUD
 *
 * @package thred\base
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2016, VipDesign
 */
class ActionCRUD extends Action
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
    public $view = '_form';

    /**
     * Working model class name
     * Model should extends \yii\db\ActiveRecord
     *
     * @var string
     */
    public $modelClass = null;

    /**
     * Working model class name
     * Model should extends \yii\db\ActiveRecordLang
     *
     * @var string
     */
    public $modelClassLang = null;

    /**
     * Redirect action
     *
     * @var string | array | \Closure
     */
    public $redirect = 'update';

    /**
     * Scenario name for model validation
     *
     * @var string
     */
    public $scenario = 'backend';

    /**
     * @var null
     */
    public $afterRunCallback = null;

    /**
     * @var null
     */
    public $beforeRunCallback = null;

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
     * Lang model
     *
     * @var \yii\db\ActiveRecord
     */
    protected $modelLang = null;

    /**
     * @var bool
     */
    public $useLog = true;

    /**
     * @var array
     */
    public $logMessage = [
        'message' => '',
        'url' => '',
    ];

    /**
     * Find model by primary key
     * If model not found - return null
     *
     * @param integer | array $model_id
     * @param string $className
     * @return null | Model
     */
    public function findModel($model_id, $className = '')
    {
        $modelClass = empty($className) ? $this->model : new $className;
        $keys = $modelClass::primaryKey();

        $model = null;

        if (count($keys) > 1) {
            $values = explode(',', $model_id);
            if (count($keys) === count($values)) {
                $model = $modelClass::findOne(array_combine($keys, $values));
            }
        } elseif ($model_id !== null) {
            $model = $modelClass::findOne($model_id);
        }

        return $model;
    }

    /**
     * Find language model by primary key
     * If model not found - return null
     *
     * @param integer $modelId
     * @return Model
     */
    protected function findModelLang($modelId)
    {
        $model = null;

        if ($modelId) {
            $model = $this->modelLang->find()->andWhere(['rid' => $modelId])->one();
        }

        if ($model === null) {
            $model = $this->modelLang->loadDefaultValues();
        }

        return $model;
    }

    /**
     * Get after save redirect
     *
     * @return mixed
     */
    public function getRedirect()
    {
        $redirect = $this->redirect;
        if (is_array($redirect)) {
            $red = $redirect;
        } elseif ($redirect instanceof \Closure) {
            $red = $redirect();
        } else {
            $red = [$this->redirect, 'id' => $this->model->id];
        }
        return $red;
    }

    /**
     * Returns created data model
     * @return object ActiveRecord
     */
    public function getModel()
    {
        return $this->model;
    }


    /**
     * Action which is executed after action
     */
    protected function afterRun()
    {
        if ($this->afterRunCallback instanceof Closure) {
            $f = $this->afterRunCallback;
            $f($this);
        }
        parent::afterRun();
    }

    /**
     * @return bool
     */
    protected function beforeRun()
    {
        if ($this->beforeRunCallback instanceof Closure) {
            $f = $this->beforeRunCallback;
            $f($this);
        }

        return parent::beforeRun();
    }

    /**
     *
     */
    public function sendToLog()
    {
        /**
         * @var $loogbook \thread\modules\sys\modules\logbook\components\Logbook
         */
        $logbook = Yii::$app->get('logbook', false);
        if ($logbook !== null) {
            $module = (Yii::$app->controller->module->module->id == "app-backend")
                ? Yii::$app->controller->module->id
                : Yii::$app->controller->module->module->id . '/' . Yii::$app->controller->module->id;

            $controller = Yii::$app->controller->id;
            $category = $module . '/' . $controller;
            $info = $this->getLogInfo();

            $model_name = $this->getModel()->formName();
            $action_method = Yii::$app->controller->action->id;
            $model_id = $this->getModel()->id;

            $logbook->send($info['message'], $info['url'] ?? '', Logbook::TYPE_NOTICE, $category, $model_name, $action_method, $model_id);

            if (in_array($model_name, ['Product', 'Composition', 'FactoryPricesFiles', 'FactoryCatalogsFiles'])) {
                Yii::$app->logbookByMonth->send($action_method . $model_name);
            }
        } else {
            Yii::getLogger()->log('logbook service was not found', Logger::LEVEL_ERROR);
        }
    }

    /**
     * @return string
     */
    public function getLogInfo()
    {
        $m = $this->logMessage;
        if ($m instanceof \Closure) {
            $message = $m();
        } elseif (!empty($m['message'])) {
            $message = $m;
        } else {
            $message['message'] = "Model ID:" . $this->getModel()->id;
            $message['url'] = Url::toRoute(['/' . Yii::$app->controller->module->id . '/' . Yii::$app->controller->id . '/list']);
        }

        return $message;
    }
}
