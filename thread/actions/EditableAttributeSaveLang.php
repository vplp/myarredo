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
 * @copyright (c) 2016, VipDesign
 * @usage
 * public function actions()
 * {
 *     return [
 *          ...
 *          'attribute-save' => [
 *              'class' => EditableAttributeSaveLang::class,
 *              'modelClass' => $this->modelLang,
 *              'attribute' => 'title',
 *          ],
 *          ...
 *    ];
 * }
 */
class EditableAttributeSaveLang extends ActionCRUD
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
        if ($model = $this->findModelLang($attributeId)) {
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
            $model = $this->model->find()->andWhere(['rid' => $modelId])->one();
        }

        if ($model === null) {
            $model = new $this->modelClass;
            $model->rid = $modelId;
            $model->lang = Yii::$app->language;
        }

        return $model;
    }
}