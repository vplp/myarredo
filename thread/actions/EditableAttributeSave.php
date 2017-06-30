<?php

namespace thread\actions;

use Yii;
use yii\base\Exception;
use yii\web\Response;
use yii\log\Logger;
//
use thread\app\base\models\ActiveRecord;

/**
 * Class EditableAttributeSave
 *
 * @package thread\actions
 * @author FilamentV <vortex.filament@gmail.com>
 * @author Roman Gonchar <roman.gonchar92@gmail.com>
 * @copyright (c) 2016, VipDesign
 * @usage
 * public function actions()
 * {
 *     return [
 *          ...
 *          'published' => [
 *              'class' => EditableAttributeSave::class,
 *              'modelClass' => Model::class,
 *              'attribute' => 'published'
 *          ],
 *          ...
 *    ];
 * }
 */
class EditableAttributeSave extends ActionCRUD
{

    /**
     * Model Attribute
     *
     * @var string
     */
    public $attribute;
    /**
     * @var string
     */
    public $returnValue = '';

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
        $this->model = new $this->modelClass;

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

    /**
     * Run action
     */
    public function run()
    {
        $data = Yii::$app->getRequest()->post($this->attribute, null);
        Yii::$app->getResponse()->format = Response::FORMAT_JSON;

        if ($data !== null) {
            foreach ($data as $key => $value) {
                $this->save($key, $value);
                break;
            }

        }

        return ['output' => $this->getReturnValue($value), 'message' => ''];
    }

    /**
     * @param $value
     * @return mixed
     */
    public function getReturnValue($value)
    {
        if ($this->returnValue instanceof \Closure) {
            $m = $this->returnValue;
            return $m($this->model);
        }
        return $this->model[$this->returnValue]??$value;
    }

    /**
     * Save model data
     *
     * @param integer $attributeId
     * @param mixed $value
     * @return bool
     */
    protected function save($attributeId, $value)
    {
        $save = false;
        /** @var ActiveRecord $model */
        if ($model = $this->findModel($attributeId)) {
            $model->setScenario($this->attribute);
            $model->{$this->attribute} = $value;
            $transaction = $model::getDb()->beginTransaction();
            try {
                $save = $model->save();
                ($save) ? $transaction->commit() : $transaction->rollBack();
            } catch (Exception $e) {
                Yii::getLogger()->log($e->getMessage(), Logger::LEVEL_ERROR);
                $transaction->rollBack();
            }
            $this->model = $model;
        }
        return $save;
    }
}
