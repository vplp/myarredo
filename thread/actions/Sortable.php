<?php

namespace thread\actions;

use Yii;
use yii\base\Exception;
use yii\helpers\Url;
use yii\web\Response;
use yii\log\Logger;
use thread\app\base\models\ActiveRecord;

/**
 * Class Sortable
 *
 * @package thread\actions
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 *
 * public function actions() {
 * return [
 * ...
 * 'sortable' => [
 * 'class' => AttributeKeySwith::class,
 * 'modelClass' => Model::class,
 * 'attribute' => 'position'
 * ],
 * ...
 * ];
 * }
 *
 */
class Sortable extends ActionCRUD
{

    /**
     * Атрибут моделі
     * @var string
     */
    public $attribute;

    /**
     *
     * @var array|string|\Closure
     */
    public $redirect = ['list'];

    /**
     * @var string
     */
    public $rows_data_post_attribute = 'rows_data';

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

    /**
     * @return bool
     */
    public function run()
    {
        $save = $this->save(Yii::$app->getRequest()->post($this->rows_data_post_attribute, []));
        if (Yii::$app->getRequest()->isAjax) {
            Yii::$app->getResponse()->format = Response::FORMAT_JSON;
            return $save;
        } else {
            $this->controller->redirect($this->getRedirect());
        }
    }

    /**
     * @param $rows_data
     * @return bool
     */
    protected function save($rows_data)
    {
        $save = false;
        if (empty($rows_data)) {
            return $save;
        }
        $model = $this->model;
        $tableName = $model::tableName();
        $fieldName = $this->attribute;

//        var_dump($rows_data);
        $id = [];
        $data = [];
        foreach ($rows_data as $key => $val) {
            $id[] = $val;
            $data[] = $key;
        }

        $transaction = $model::getDb()->beginTransaction();
        try {
            $sql = "UPDATE " . $tableName . " SET " . $fieldName . " = ELT( FIELD( id,  " . implode(",", $id) . " ) , " . implode(",", $data) . " ) WHERE id IN (" . implode(",", $id) . ")";
            $save = $model::getDb()->createCommand($sql)->execute();
            if ($save > 0) {
                $save = true;
            }
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
            $mess['message'] = Yii::t('app', 'Update') . " attribute:" . $model->getAttributeLabel($this->attribute);
            $mess['url'] = Url::toRoute(['/' . $module . '/' . $controller . '/list']);
        }
        return $mess;
    }
}
