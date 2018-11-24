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
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
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
                    /**
                     * message
                     */
                    Yii::$app->session->setFlash(
                        'success',
                        Yii::t('app', 'Отправлено')
                    );
//
//                    /**
//                     * send letter
//                     */
//                    Yii::$app
//                        ->mailer
//                        ->compose(
//                            '@app/modules/catalog/mail/form_feedback_letter.php',
//                            [
//                                'model' => $model,
//                            ]
//                        )
//                        ->setTo(Yii::$app->params['form_feedback']['setTo'])
//                        ->setSubject('Связаться с оператором сайта')
//                        ->send();

                    return $this->redirect(Yii::$app->request->referrer ? Yii::$app->request->referrer : Yii::$app->homeUrl);
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
}
