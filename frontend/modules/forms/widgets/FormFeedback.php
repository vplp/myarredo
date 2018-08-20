<?php

namespace frontend\modules\forms\widgets;

use Yii;
use yii\base\Exception;
use yii\base\Widget;
use yii\log\Logger;
use frontend\modules\forms\models\FormsFeedback;

/**
 * Class FeedbackForm
 *
 * @package frontend\modules\forms\widgets
 */
class FormFeedback extends Widget
{
    /**
     * @var string
     */
    public $view = 'form_feedback';

    /**
     * @return string
     * @throws \yii\db\Exception
     */
    public function run()
    {
        $model = new FormsFeedback(['scenario' => 'frontend']);

        if ($model->load(Yii::$app->getRequest()->post()) && $model->validate()) {
            $transaction = $model::getDb()->beginTransaction();
            try {
                $model->published = '1';

                $save = $model->save();

                $save ? $transaction->commit() : $transaction->rollBack();

                if ($save) {

                    // message
                    Yii::$app->session->setFlash(
                        'success',
                        Yii::t('app', 'Отправлено')
                    );

                    // send letter
                    Yii::$app
                        ->mailer
                        ->compose(
                            '@app/modules/catalog/mail/form_feedback_letter.php',
                            [
                                'model' => $model,
                            ]
                        )
                        ->setTo(Yii::$app->params['form_feedback']['setTo'])
                        ->setSubject('Связаться с оператором сайта')
                        ->send();

                    // reset models
                    $model = new FormsFeedback(['scenario' => 'frontend']);
                }
            } catch (Exception $e) {
                Yii::getLogger()->log($e->getMessage(), Logger::LEVEL_ERROR);
                $transaction->rollBack();
            }
        }

        return $this->render($this->view, [
            'model' => $model
        ]);
    }
}