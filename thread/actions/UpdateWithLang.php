<?php

namespace thread\actions;

use Yii;
use yii\base\Exception;
use yii\web\NotFoundHttpException;
use yii\log\Logger;
//
use thread\app\base\models\ActiveRecord;
use thread\modules\seo\modules\modellink\components\Crud;

/**
 * Class UpdateWithLang
 *
 * @package thread\actions
 * @author FilamentV <vortex.filament@gmail.com>
 * @author Roman Gonchar <roman.gonchar92@gmail.com>
 * @copyright (c) 2016, VipDesign
 * @usage
 * public function actions() {
 *      return [
 *          ...
 *          'create' => [
 *              'class' => CreateWithLang::class,
 *              'modelClass' => Model::class,
 *              'modelClassLang' => ModelLang::class
 *          ],
 *          ...
 *      ];
 * }
 */
class UpdateWithLang extends ActionCRUD
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
        if ($this->modelClassLang === null) {
            throw new Exception(__CLASS__ . '::modelClassLang must be set.');
        }
        $this->model = new $this->modelClass;
        $this->modelLang = new $this->modelClassLang;
        /** @var ActiveRecord $this ->model */
        if ($this->model === null) {
            throw new Exception($this->modelClass . 'must be exists.');
        }
        if ($this->modelLang === null) {
            throw new Exception($this->modelClassLang . 'must be exists.');
        }
        if (!$this->model->isScenario($this->scenario)) {
            throw new Exception($this->modelClass . '::' . $this->scenario . " scenario doesn't exist");
        }
        if (!$this->modelLang->isScenario($this->scenario)) {
            throw new Exception($this->modelClassLang . '::' . $this->scenario . " scenario doesn't exist");
        }
    }

    /**
     * Run action
     *
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function run($id)
    {
        $this->model = $this->findModel($id);
        $this->modelLang = $this->findModelLang($id);
        if ($this->model == null) {
            throw new NotFoundHttpException;
        }
        if (Yii::$app->getRequest()->isAjax) {
            return $this->controller->renderPartial($this->view, [
                'model' => $this->model,
                'modelLang' => $this->modelLang,
            ]);
        } else {
            if ($this->saveModel()) {
                return $this->controller->redirect($this->getRedirect());
            } else {
                $this->controller->layout = $this->layout;
                return $this->controller->render($this->view, [
                    'model' => $this->model,
                    'modelLang' => $this->modelLang,
                ]);
            }
        }
    }

    /**
     * Save data to DB
     * Scenario 'backend' should be set for model
     *
     * @return bool
     */
    public function saveModel()
    {
        $save = false;
        $this->model->setScenario($this->scenario);
        $this->modelLang->setScenario($this->scenario);

        if ($this->model->load(Yii::$app->getRequest()->post())) {
            $model = $this->model;
            $transaction = $model::getDb()->beginTransaction();
            try {
                $save = $this->model->save();
                if ($save && $this->modelLang->load(Yii::$app->getRequest()->post())) {
                    $this->modelLang->rid = $this->model->id;
                    $this->modelLang->lang = Yii::$app->language;
                    //
                    $save = $this->modelLang->save();
                }
                $save ? $transaction->commit() : $transaction->rollBack();
                if ($save) {
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
        if ($this->afterSaveCallback instanceof Closure) {
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
        $seoCrud->findModel(Crud::getModelKey($model), $model->id)->getPostModel()->saveModel();
    }
}
