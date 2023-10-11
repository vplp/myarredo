<?php

namespace thread\actions;

use Yii;
use yii\base\Exception;
use yii\helpers\Url;
use yii\web\Response;
use yii\log\Logger;
use thread\app\base\models\ActiveRecord;
use thread\modules\seo\modules\modellink\components\Crud;

/**
 * Class Delete
 *
 * @package thread\actions
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2016, VipDesign
 * @usage
 * public function actions() {
 *      return [
 *          ...
 *          'delete' => [
 *              'class' => Delete::class,
 *              'modelClass' => Model::class,
 *              'attribute' => 'delete'
 *          ],
 *          ...
 *      ];
 * }
 */
class Delete extends ActionCRUD
{
    /**
     * Redirect action
     *
     * @var array
     */
    public $redirect = ['trash'];

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
        $this->model = new $this->modelClass;
        if ($this->model === null) {
            throw new Exception($this->modelClass . '::$modelClass must be set.');
        }
    }

    /**
     * Run action
     *
     * @param $id
     * @return bool
     * @throws \Exception
     */
    public function run($id)
    {
        $delete = false;
        /** @var ActiveRecord $model */
        if ($model = $this->findModel($id)) {
            $transaction = $model::getDb()->beginTransaction();
            try {
                $this->seoModelDelete($model);
                $delete = $model->delete();
                ($delete) ? $transaction->commit() : $transaction->rollBack();

                //LOG
                if ($this->useLog && $delete) {
                    $this->model = $model;
                    $this->sendToLog();
                }
            } catch (Exception $e) {
                Yii::getLogger()->log($e->getMessage(), Logger::LEVEL_ERROR);
                $transaction->rollBack();
            }
        }
        if (Yii::$app->getRequest()->isAjax) {
            Yii::$app->getResponse()->format = Response::FORMAT_JSON;
            return $delete;
        } else {
            $this->controller->redirect($this->getRedirect());
        }
        return $delete;
    }

    /**
     * @param ActiveRecord $model
     */
    public function seoModelDelete(ActiveRecord $model)
    {
        $seoCrud = new Crud();
        $seoCrud->getByModel($model)->delete();
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
            $mess['message'] = Yii::t('app', 'Delete') . ":" . $title;
            $mess['url'] = Url::toRoute(['/' . $module . '/' . $controller . '/list']);
        }
        return $mess;
    }
}
