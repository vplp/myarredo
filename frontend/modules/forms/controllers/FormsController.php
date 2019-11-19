<?php

namespace frontend\modules\forms\controllers;

use Yii;
use yii\log\Logger;
use yii\base\Exception;
use yii\filters\VerbFilter;
//
use frontend\components\BaseController;
use frontend\modules\forms\models\FormsFeedback;

/**
 * Class FormsController
 *
 * @package frontend\modules\forms\controllers
 */
class FormsController extends BaseController
{
    public $title = '';

    public $defaultAction = 'feedback';

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'feedback' => ['post', 'get'],
                    'feedback-partner' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionFeedback()
    {
        $this->title = Yii::t('app', 'Связаться с оператором сайта');

        $model = new FormsFeedback(['scenario' => 'frontend']);

        if ($model->load(Yii::$app->getRequest()->post()) && $model->validate()) {
            $transaction = $model::getDb()->beginTransaction();
            try {
                $model->published = '1';

                $save = $model->save();

                $save ? $transaction->commit() : $transaction->rollBack();

                if ($save) {
                    $subject = 'Связаться с оператором сайта';
                    /**
                     * send letter
                     */
                    Yii::$app
                        ->mailer
                        ->compose(
                            '@app/modules/forms/mail/form_feedback_letter.php',
                            [
                                'subject' => $subject,
                                'model' => $model,
                            ]
                        )
                        ->setTo(Yii::$app->params['form_feedback']['setTo'])
                        ->setSubject($subject)
                        ->send();

                    /**
                     * message
                     */
                    Yii::$app->session->setFlash(
                        'success',
                        Yii::t('app', 'Отправлено')
                    );

                    return $this->redirect(Yii::$app->request->referrer);
                }
            } catch (Exception $e) {
                Yii::getLogger()->log($e->getMessage(), Logger::LEVEL_ERROR);
                $transaction->rollBack();
            }
        }

        return $this->render('feedback', [
            'model' => $model
        ]);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionFeedbackPartner()
    {
        $model = new FormsFeedback(['scenario' => 'frontend']);

        if ($model->load(Yii::$app->getRequest()->post()) && $model->validate()) {
            $transaction = $model::getDb()->beginTransaction();
            try {
                $model->published = '1';

                $save = $model->save();

                $save ? $transaction->commit() : $transaction->rollBack();

                if ($save) {
                    $subject = 'Связаться с салоном';
                    /**
                     * send letter
                     */
                    Yii::$app
                        ->mailer
                        ->compose(
                            '@app/modules/forms/mail/form_feedback_letter.php',
                            [
                                'subject' => $subject,
                                'model' => $model,
                            ]
                        )
                        ->setTo($model->partner->email)
                        ->setSubject($subject)
                        ->send();

                    /**
                     * message
                     */
                    Yii::$app->session->setFlash(
                        'success',
                        Yii::t('app', 'Отправлено')
                    );

                    return $this->redirect(Yii::$app->request->referrer);
                }
            } catch (Exception $e) {
                Yii::getLogger()->log($e->getMessage(), Logger::LEVEL_ERROR);
                $transaction->rollBack();
            }
        }
    }
}
