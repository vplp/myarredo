<?php
namespace thread\actions;

use Yii;
use yii\base\Exception;
use yii\web\Response;
use yii\log\Logger;
use thread\app\base\models\ActiveRecord;

/**
 * Class CustomAttributeSwitch
 *
 * @package thread\actions
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
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
class AjaxManyToMany extends ActionCRUD
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
     * @var ActiveRecord
     */
    protected $model = null;

    public $primaryKeyFirstTable = null;

    public $valueFirstTable = null;

    public $primaryKeySecondTable = null;

    public $valueSecondTable = null;

    /** @var null if не установлен атрибут, тогда создаем или  удаляем модель (кортеж))) */
    public $additionalFields = null;


    private $_checked = null;







    public function init()
    {
        $params = Yii::$app->getRequest()->get();

        if (Yii::$app->getRequest()->isAjax) {
            $this->modelClass = $params['namespace'];
//            $this->attribute = $params['attribute'];
            $this->primaryKeyFirstTable = $params['primaryKeyFirstTable'];
            $this->valueFirstTable = $params['valueFirstTable'];
            $this->primaryKeySecondTable = $params['primaryKeySecondTable'];
            $this->valueSecondTable = $params['valueSecondTable'];
            $this->additionalFields = $params['additionalFields'];
            $this->_checked = ($params['checked'] == 'true') ?: false;
        }


        if ($this->modelClass === null) {
            throw new Exception(__CLASS__ . '::$modelClass must be set.');
        }

        $this->model = new $this->modelClass;

        if ($this->model === null) {
            throw new Exception($this->modelClass . 'must be exists.');
        }

//        if (!$this->model->isAttribute($this->attribute)) {
//            throw new Exception($this->modelClass . '::' . $this->attribute . ' attribute doesn\'t exist');
//        }
//        if (!$this->model->isScenario($this->attribute)) {
//            throw new Exception($this->modelClass . '::' . $this->attribute . ' scenario doesn\'t exist');
//        }

        if (!$this->model->isAttribute('id')) {
            throw new Exception($this->modelClass . '::' . $this->id . ' scenario doesn\'t exist');
        }
    }



    public function run($id)
    {
        $namespace = $this->modelClass;

        $this->model = $namespace::findOne([
            $this->primaryKeyFirstTable => $this->valueFirstTable,
            $this->primaryKeySecondTable => $this->valueSecondTable,
        ]);

        $save = false;

        /** Удаляем если значение 0 и не обновляем атрибут */
        if ($this->_checked === false &&  ! $this->additionalFields) {
            $this->dropColumn();
        } elseif ($this->additionalFields) {
            /** Обновляем аттрибут */
            $save =  $this->updateRow();
        } else {

            /** Обновляем аттрибут */
            $save =  $this->createRow();

        }


        if (Yii::$app->getRequest()->isAjax) {
            Yii::$app->getResponse()->format = Response::FORMAT_JSON;

            return $save;
        } else {
            $this->controller->redirect($this->getRedirect());
        }
    }

    /**
     *
     */
    protected function updateRow()
    {

        if ($model = $this->model) {
            $model->setScenario($this->additionalFields);
            $model->{$this->additionalFields} = ($model->{$this->additionalFields} == ActiveRecord::STATUS_KEY_ON) ? ActiveRecord::STATUS_KEY_OFF : ActiveRecord::STATUS_KEY_ON;
            $transaction = $model::getDb()->beginTransaction();
            try {
                $save = $model->save();
                ($save) ? $transaction->commit() : $transaction->rollBack();
            } catch (Exception $e) {
                Yii::getLogger()->log($e->getMessage(), Logger::LEVEL_ERROR);
                $transaction->rollBack();
            }
        }
    }

    /**
     *
     */
    protected function createRow()
    {
        $namespace = $this->modelClass;

        $model = new $namespace(['scenario' => 'backend']);
        $model->{$this->primaryKeyFirstTable} = $this->valueFirstTable;
        $model->{$this->primaryKeySecondTable} = $this->valueSecondTable;


        $transaction = $model::getDb()->beginTransaction();
        try {
            $save = $model->save();
            ($save) ? $transaction->commit() : $transaction->rollBack();
        } catch (Exception $e) {
            Yii::getLogger()->log($e->getMessage(), Logger::LEVEL_ERROR);
            $transaction->rollBack();
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
            } catch (Exception $e) {
                Yii::getLogger()->log($e->getMessage(), Logger::LEVEL_ERROR);
                $transaction->rollBack();
            }
        }

        return json_encode(['success' => ($save) ? 'true' : 'false']);
    }


    /**
     * Удаляем запись в бд
     */

    protected function dropColumn()
    {
        $namespace = $this->modelClass;
        $namespace::deleteAll([
            $this->primaryKeyFirstTable => $this->valueFirstTable,
            $this->primaryKeySecondTable => $this->valueSecondTable
        ]);
    }
}
