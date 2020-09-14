<?php

namespace thread\actions;

use Yii;
use yii\base\Exception;
use yii\web\Response;
use yii\log\Logger;
use thread\app\base\models\ActiveRecord;

/**
 * Class UpdatePosition
 *
 * @package thread\actions
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 *
 * public function actions() {
 * return [
 * ...
 * 'sort_save' => [
 * 'class' => UpdatePosition::class,
 * 'modelClass' => Model::class,
 * 'attribute' => 'position'
 * ],
 * ...
 * ];
 * }
 *
 */
class UpdatePosition extends ActionCRUD
{

    /**
     * Атрибут моделі
     * @var string
     */
    public $attribute = 'position';

    /**
     * Атрибут запиту
     * @var string
     */
    public $request_attribute = 'sort_order';

    /**
     *
     * @var array|string|\Closure
     */
    public $redirect = ['list'];

    /**
     * @var ActiveRecord
     */
    protected $model = null;

    public function init()
    {
        if ($this->modelClass === null) {
            throw new Exception(__CLASS__ . '::$modelClass must be set.');
        }
        $this->model = new $this->modelClass;

        if ($this->model === null) {
            throw new Exception($this->modelClass . 'must be exists.');
        }
        if (!$this->model->isAttribute($this->attribute)) {
            throw new Exception($this->modelClass . '::' . $this->attribute . ' attribute doesn\'t exist');
        }
        if (!$this->model->isScenario($this->attribute)) {
            throw new Exception($this->modelClass . '::' . $this->attribute . ' scenario doesn\'t exist');
        }
    }

    public function run()
    {
        $save = $this->save();
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

        $sort_order = Yii::$app->getRequest()->post($this->request_attribute);
        if (!empty($sort_order)) {
            var_dump($sort_order);
        }
        exit();

//        if ($model = $this->findModel($id)) {
//            $model->setScenario($this->attribute);
//            $model->{$this->attribute} = ($model->{$this->attribute} == ActiveRecord::STATUS_KEY_ON) ? ActiveRecord::STATUS_KEY_OFF : ActiveRecord::STATUS_KEY_ON;
//            $transaction = $model::getDb()->beginTransaction();
        try {
            $save = $model->save();
            ($save) ? $transaction->commit() : $transaction->rollBack();
        } catch (Exception $e) {
            Yii::getLogger()->log($e->getMessage(), Logger::LEVEL_ERROR);
            $transaction->rollBack();
        }
//        }
        return $save;
    }
}
