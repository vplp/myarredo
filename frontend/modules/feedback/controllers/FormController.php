<?php

namespace frontend\modules\feedback\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\base\Exception;
use yii\log\Logger;
use frontend\components\BaseController;
use frontend\modules\feedback\models\Question;

/**
 * Class FormController
 *
 * @package frontend\modules\feedback\controllers
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class FormController extends BaseController
{
    public $defaultAction = 'index';

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'send' => ['post'],
                ],
            ],
        ];
    }

    /**
     *
     */
    public function actionSend()
    {
        $model = new Question([
            'scenario' => 'add_feedback'
        ]);
        if ($model->load(Yii::$app->getRequest()->post())) {
            $transaction = $model::getDb()->beginTransaction();
            try {
                $save = $model->save();

                ($save) ? $transaction->commit() : $transaction->rollBack();
                if ($save) {
                    Yii::$app->getSession()->addFlash('feedback-form-send', 'alert-success');
                }
            } catch (Exception $e) {
                Yii::getLogger()->log($e->getMessage(), Logger::LEVEL_ERROR);
                $transaction->rollBack();
            }
        }
        return $this->redirect(['feedback/index']);
    }
}
