<?php

namespace thread\actions;

use Closure;
use yii\base\Action;
use yii\base\Model;

/**
 * Class ActionCRUD
 *
 * @package thred\base
 * @author FilamentV <vortex.filament@gmail.com>
 * @author Roman Gonchar <roman.gonchar92@gmail.com>
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
     *
     * @var null
     */
    public $afterRunCallback = null;

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
    public function afterRun()
    {
        if ($this->afterRunCallback instanceof Closure) {
            $f = $this->afterRunCallback;
            $f($this);
        }
        parent::afterRun();
    }
}
