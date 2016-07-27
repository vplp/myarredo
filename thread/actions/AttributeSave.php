<?php
namespace thread\actions;

use Yii;
use yii\base\Exception;
use yii\web\Response;
use yii\log\Logger;
//
use thread\app\base\models\ActiveRecord;

/**
 * Class AttributeSave
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
 *              'class' => AttributeSave::class,
 *              'modelClass' => Model::class,
 *              'attribute' => 'published'
 *          ],
 *          ...
 *    ];
 * }
 */
class AttributeSave extends ActionCRUD
{

    /**
     * Model Attribute
     *
     * @var string
     */
    public $attribute;

    /**
     * Link to Redirect
     *
     * @var string | array | \Closure
     */
    public $redirect = ['list'];

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
        /** @var ActiveRecord $this->model */
        $this->model = new $this->modelClass;
        if ($this->model === null) {
            throw new Exception($this->modelClass . 'must be exists.');
        }
        if (!$this->model->is_attribute($this->attribute)) {
            throw new Exception($this->modelClass . '::' . $this->attribute . " attribute doesn't exist");
        }
        if (!$this->model->is_scenario($this->attribute)) {
            throw new Exception($this->modelClass . '::' . $this->attribute . " scenario doesn't exist");
        }
    }

    /**
     * Run action
     *
     * @param $attributeId
     * @param $value
     * @return bool|Response
     */
    public function run($attributeId, $value)
    {
        $save = $this->save($attributeId, $value);
        if (Yii::$app->getRequest()->isAjax) {
            Yii::$app->getResponse()->format = Response::FORMAT_JSON;
            return $save;
        }
        return $this->controller->redirect($this->getRedirect());
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
        }
        return $save;
    }
}
