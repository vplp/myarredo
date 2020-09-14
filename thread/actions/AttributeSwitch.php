<?php

namespace thread\actions;

use Yii;
use yii\base\Exception;
use yii\helpers\Url;
use yii\web\Response;
use yii\log\Logger;
use thread\app\base\models\ActiveRecord;

/**
 * Class AttributeSwith
 *
 * @package thread\actions
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 *
 * public function actions() {
 * return [
 * ...
 * 'published' => [
 * 'class' => AttributeKeySwith::class,
 * 'modelClass' => Model::class,
 * 'attribute' => 'published'
 * ],
 * ...
 * ];
 * }
 *
 */
class AttributeSwitch extends ActionCRUD
{
    /**
     * @var
     */
    public $attribute;

    /**
     * @var array
     */
    public $redirect = ['list'];

    /**
     * @var ActiveRecord
     */
    protected $model = null;

    /**
     * Init action
     *
     * @throws Exception
     */
    public function init()
    {
        if ($this->modelClass === null) {
            throw new Exception(__CLASS__ . '::$modelClass must be set.');
        }

        /** @var ActiveRecord $this ->model */
        $this->model = new $this->modelClass();

        if ($this->model === null) {
            throw new Exception($this->modelClass . 'must be exists.');
        }
        if (!$this->model->isAttribute($this->attribute)) {
            throw new Exception($this->modelClass . '::' . $this->attribute . " attribute doesn't exist");
        }
        if (!$this->model->isScenario($this->attribute)) {
            throw new Exception($this->modelClass . '::' . $this->attribute . " scenario doesn't exist");
        }
    }

    public function run($id)
    {
        $save = $this->save($id);
        if (Yii::$app->getRequest()->isAjax) {
            Yii::$app->getResponse()->format = Response::FORMAT_JSON;
            return $save;
        } else {
            $this->controller->redirect($this->getRedirect());
        }
    }

    /**
     * Зберігає дані моделі
     * @param integer $id
     * @return bool
     */
    protected function save($id)
    {
        $save = false;
        if ($model = $this->findModel($id)) {
            $model->setScenario($this->attribute);
            $model->{$this->attribute} = ($model->{$this->attribute} == ActiveRecord::STATUS_KEY_ON) ? ActiveRecord::STATUS_KEY_OFF : ActiveRecord::STATUS_KEY_ON;
            $transaction = $model::getDb()->beginTransaction();
            try {
                $save = $model->save();
                ($save) ? $transaction->commit() : $transaction->rollBack();

                //LOG
                if ($this->useLog && $save) {
                    $this->model = $model;
                    $this->sendToLog();
                }
            } catch (Exception $e) {
                Yii::getLogger()->log($e->getMessage(), Logger::LEVEL_ERROR);
                $transaction->rollBack();
            }
        }
        return $save;
    }

    /**
     * @return string
     */
    public function getLogInfo()
    {
        $m = $this->logMessage;
        if ($m instanceof \Closure) {
            $mess = $m();
        } elseif (!empty($m['message'])) {
            $mess = $m;
        } else {
            $module = (Yii::$app->controller->module->module->id == "app-backend") ?
                Yii::$app->controller->module->id : Yii::$app->controller->module->module->id . '/' . Yii::$app->controller->module->id;
            $controller = Yii::$app->controller->id;
            $model = $this->getModel();
            $title = (isset($model['lang']['title'])) ? $model['lang']['title'] : ((isset($model['title'])) ? $model['title'] : $model->id);
            $mess['message'] = Yii::t('app', 'Update') . " attribute:" . $model->getAttributeLabel($this->attribute) . '->' . $title;
            $mess['url'] = Url::toRoute(['/' . $module . '/' . $controller . '/update', 'id' => $this->getModel()->id]);
        }
        return $mess;
    }
}
