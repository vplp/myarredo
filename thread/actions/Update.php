<?php

namespace thread\actions;

use Yii;
use yii\base\Exception;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\log\Logger;
use thread\app\base\models\ActiveRecord;
use thread\modules\seo\modules\modellink\components\Crud;

/**
 * Class Update
 *
 * @package thread\actions
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2016, VipDesign
 * @usage
 * public function actions() {
 *      return [
 *          ...
 *          'create' => [
 *              'class' => Update::class,
 *              'modelClass' => Model::class,
 *          ],
 *          ...
 *      ];
 *  }
 */
class Update extends ActionCRUD
{

    /**
     * @var Closure|null
     */
    public $afterSaveCallback = null;

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
     * @param $id
     * @return string|\yii\web\Response
     * @throws Exception
     * @throws NotFoundHttpException
     */
    public function run($id)
    {
        if ($this->model === null) {
            throw new Exception($this->modelClass . 'must be exists.');
        }
        if (Yii::$app->getRequest()->isAjax) {
            return $this->controller->renderPartial($this->view, [
                'model' => $this->model,
            ]);
        } else {
            if ($this->saveModel($id)) {
                $this->afterSaveModel();
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
     * Save data to DB
     * Scenario 'backend' should be set for model
     *
     * @param $id
     * @param string $className
     * @return bool
     * @throws NotFoundHttpException
     */
    public function saveModel($id, $className = '')
    {
        $save = false;
        $this->model = $this->findModel($id, $className);
        if ($this->model === null) {
            throw new NotFoundHttpException;
        }
        $this->model->setScenario($this->scenario);
        if ($this->model->load(Yii::$app->getRequest()->post())) {
            /** @var ActiveRecord $model */
            $model = $this->model;
            $transaction = $model::getDb()->beginTransaction();
            try {
                /** @var ActiveRecord $this ->model */
                $save = $this->model->save();
                $save ? $transaction->commit() : $transaction->rollBack();
                if ($save) {
                    //LOG
                    if ($this->useLog) {
                        $this->model = $model;
                        $this->sendToLog();
                    }

                    $this->saveSeoModel();
                    $this->afterSaveModel();
                }
            } catch (Exception $e) {
                Yii::getLogger()->log($e->getMessage(), Logger::LEVEL_ERROR);
                $transaction->rollBack();
            }
        }
        return $save;
    }

    /**
     * Run Callback function if model saved correctly
     */
    protected function afterSaveModel()
    {
        if ($this->afterSaveCallback instanceof \Closure) {
            $f = $this->afterSaveCallback;
            $f($this);
        }
    }

    /**
     *
     */
    public function saveSeoModel()
    {
        $model = $this->model;
        //
        $seoCrud = new Crud();
        $seoCrud->getByModel($model)->delete()->getPostModel()->saveModel();
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
            $module = (Yii::$app->controller->module->module->id == "app-backend")
                ? Yii::$app->controller->module->id
                : Yii::$app->controller->module->module->id . '/' . Yii::$app->controller->module->id;
            $controller = Yii::$app->controller->id;
            $model = $this->getModel();
            $title = (isset($model['lang']['title'])) ? $model['lang']['title'] : ((isset($model['title'])) ? $model['title'] : $model->id);
            $mess['message'] = Yii::t('app', 'Update') . ":" . $title;
            $mess['url'] = Url::toRoute(['/' . $module . '/' . $controller . '/update', 'id' => $this->getModel()->id]);
        }
        return $mess;
    }
}
