<?php

namespace thread\actions;

use Yii;
use yii\base\Exception;
use yii\web\Response;
use yii\log\Logger;
use thread\app\base\models\ActiveRecord;
use thread\modules\seo\modules\modellink\components\Crud;

/**
 * Class DeleteAll
 *
 * @package thread\actions
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2016, VipDesign
 * @usage
 * public function actions() {
 *      return [
 *          ...
 *          'deleteall' => [
 *              'class' => DeleteAll::class,
 *              'modelClass' => Model::class,
 *              'attribute' => 'delete'
 *          ],
 *          ...
 *      ];
 * }
 */
class DeleteAll extends ActionCRUD
{

    /**
     * @var string
     */
    public $attribute = 'deleted';

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
     * @return bool|int
     */
    public function run()
    {
        $delete = false;
        $modelClass = $this->modelClass;
        $model = $this->model;
        /** @var ActiveRecord $model */
        $transaction = $model::getDb()->beginTransaction();
        try {
            //list
            $items = $modelClass::find()->deleted()->all();
            foreach ($items as $item) {
                $this->seoModelDelete($item);
                $delete = $item->delete();
            }
            ($delete) ? $transaction->commit() : $transaction->rollBack();
        } catch (Exception $e) {
            Yii::getLogger()->log($e->getMessage(), Logger::LEVEL_ERROR);
            $transaction->rollBack();
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

}
