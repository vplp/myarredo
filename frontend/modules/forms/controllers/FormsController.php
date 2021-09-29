<?php

namespace frontend\modules\forms\controllers;

use Yii;
use yii\log\Logger;
use yii\base\Exception;
use yii\web\Response;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;
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
                    'ajax-promo' => ['post', 'get'],
                    'feedback-partner' => ['post'],
                    'ajax-get-form-feedback' => ['post', 'get'],
                ],
            ],
        ];
    }

    /**
     * @param \yii\base\Action $action
     * @return bool
     * @throws \yii\base\ExitException
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        if (in_array($action->id, ['ajax-promo'])) {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }

    /**
     * @return int[]
     */
    public function actionAjaxPromo()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->getResponse()->format = Response::FORMAT_JSON;

            if (!empty($_POST["name"]) && !empty($_POST["email"]) && !empty($_POST["textArrea"])) {
                // записываем данные которые пришли от клиента из формы
                $name = $_POST["name"];
                $email = $_POST["email"];
                $textMess = $_POST["textArrea"];

                $message = <<<HTML
            <p>Сообщение из сайта myarredo.com (Лендинг)</p>
            <p>Имя: $name</p>
            <p>Email: $email</p>
            <p>Текст сообщения: $textMess</p>
HTML;

                Yii::$app
                    ->mailer
                    ->compose(
                        '@app/modules/forms/mail/promo_letter.php',
                        [
                            'message' => $message,
                        ]
                    )
                    ->setHtmlBody($message)
                    ->setTo(Yii::$app->params['form_feedback']['setTo'])
                    ->setSubject('Сообщение из сайта myarredo.com (Лендинг)')
                    ->send();

                return ['success' => 1];
            }
        } else {
            return ['success' => 0];
        }
    }

    /**
     * @return array
     */
    public function actionAjaxGetFormFeedback()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->getResponse()->format = Response::FORMAT_JSON;

            $model = new FormsFeedback(['scenario' => 'frontend']);

            $html = $this->renderPartial('ajax_form_feedback', [
                'model' => $model,
            ]);

            return ['success' => 1, 'html' => $html];
        }
    }

    /**
     * @return string|Response
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
                        ->setTo(\Yii::$app->params['form_feedback']['setTo'])
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
     * @return Response
     */
    public function actionFeedbackPartner()
    {
        $model = new FormsFeedback(['scenario' => 'frontend']);

        if ($model->load(Yii::$app->getRequest()->post()) && $model->validate()) {
            $transaction = $model::getDb()->beginTransaction();
            try {
                $model->published = '1';

                $model->attachment = UploadedFile::getInstances($model, 'attachment');

                $save = $model->save();

                $save ? $transaction->commit() : $transaction->rollBack();

                if ($save) {
                    $subject = Yii::t('app', 'Написать салону');
                    /**
                     * send letter
                     */
                    $letter = Yii::$app
                        ->mailer
                        ->compose(
                            '@app/modules/forms/mail/form_feedback_letter.php',
                            [
                                'subject' => $subject,
                                'model' => $model,
                            ]
                        )
                        ->setTo($model->partner->email)
                        ->setCc('info@myarredo.ru')
                        ->setSubject($subject);

                    if ($model->attachment) {
                        foreach ($model->attachment as $file) {
                            $filename = Yii::getAlias('@uploads') . '/' . $file->baseName . '.' . $file->extension;
                            $file->saveAs($filename);
                            $letter->attach($filename);
                        }
                    }
                }

                $letter->send();

                if ($model->attachment) {
                    foreach ($model->attachment as $file) {
                        $filename = Yii::getAlias('@uploads') . '/' . $file->baseName . '.' . $file->extension;
                        unlink($filename);
                    }
                }

                /**
                 * message
                 */
                Yii::$app->session->setFlash(
                    'success',
                    Yii::t('app', 'Отправлено')
                );

                return $this->redirect(Yii::$app->request->referrer);
            } catch (Exception $e) {
                Yii::getLogger()->log($e->getMessage(), Logger::LEVEL_ERROR);
                $transaction->rollBack();
            }
        }
    }
}
