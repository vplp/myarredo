<?php

namespace backend\actions;

use Yii;
use yii\base\Exception;
use yii\log\Logger;

/**
 * Class UpdateWithLang
 *
 * @package backend\actions
 */
class UpdateWithLang extends \thread\actions\UpdateWithLang
{
    /**
     * Run Callback function if model saved correctly
     */
    protected function afterSaveModel()
    {
        $model = $this->model;

        $defaultLang = Yii::$app->languages->getDefault();

        if (isset($model['default_title']) && isset($model['lang']['title'])) {
            if ($defaultLang['local'] == $model['lang']['lang'] && $model['default_title'] != $model['lang']['title']) {
                $model['default_title'] = $model['lang']['title'];

                $transaction = $model::getDb()->beginTransaction();
                try {
                    $save = $model->save();
                    $save ? $transaction->commit() : $transaction->rollBack();
                } catch (Exception $e) {
                    Yii::getLogger()->log($e->getMessage(), Logger::LEVEL_ERROR);
                    $transaction->rollBack();
                }
            }

        }
        parent::afterSaveModel();
    }
}
