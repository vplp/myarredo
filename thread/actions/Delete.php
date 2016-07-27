<?php
namespace thread\actions;

use Yii;
use yii\base\Exception;
use yii\web\Response;
use yii\log\Logger;
//
use thread\app\base\models\ActiveRecord;

/**
 * Class Delete
 *
 * @package thread\actions
 * @author FilamentV <vortex.filament@gmail.com>
 * @author Roman Gonchar <roman.gonchar92@gmail.com>
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
                $delete = $model->delete();
                ($delete) ? $transaction->commit() : $transaction->rollBack();
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
}
