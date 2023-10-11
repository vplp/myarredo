<?php
namespace thread\actions;

use Yii;
use yii\base\Exception;
use yii\log\Logger;
//
use thread\app\base\models\ActiveRecord;

/**
 * Class Create
 *
 * @package thread\actions
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2016, VipDesign
 * @usage
 * public function actions()
 * {
 *      return [
 *          ...
 *          'create' => [
 *              'class' => Create::class,
 *              'modelClass' => Model::class,
 *          ],
 *          ...
 *      ];
 * }
 *
 */
class ManyToManyCreate extends ActionCRUD
{
    /** @var null nameSpace  */
    private $namespane = null;

    private $className = null;

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
        /** @var ActiveRecord $this ->model */
        $this->model = new $this->modelClass;
        $this->model->loadDefaultValues();
        if ($this->model === null) {
            throw new Exception($this->modelClass . 'must be exists.');
        }
        if (!$this->model->isScenario($this->scenario)) {
            throw new Exception($this->modelClass . '::' . $this->scenario . " scenario doesn't exist");
        }
    }

    /**
     * Run action
     *
     * @inheritdoc
     * @inheritdoc
     * @return mixed
     */
    public function run()
    {
        if (Yii::$app->getRequest()->isAjax) {
            return $this->controller->renderPartial($this->view, [
                'model' => $this->model,
            ]);
        } else {
            if ($this->saveModel()) {
                return $this->controller->redirect($this->getRedirect());
            } else {
                $this->controller->layout = $this->layout;
                return $this->controller->render($this->view, [
                    'model' => $this->model,
                ]);
            }
        }
    }

    /**
     * Save data to model
     * Model Scenario 'backend' should be set
     *
     * @return bool
     */
    public function saveModel()
    {
        $save = false;
        $this->model->setScenario($this->scenario);
        if ($this->model->load(Yii::$app->getRequest()->post())) {
            $model = $this->model;
            $transaction = $model::getDb()->beginTransaction();
            try {
                $save = $this->model->save();

                ($save) ? $transaction->commit() : $transaction->rollBack();
            } catch (Exception $e) {
                Yii::getLogger()->log($e->getMessage(), Logger::LEVEL_ERROR);
                $transaction->rollBack();
            }
        }
        return $save;
    }
}
