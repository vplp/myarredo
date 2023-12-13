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
use frontend\modules\forms\models\FormsFeedbackAfterOrder;
use frontend\modules\shop\models\Order;
use yii\web\NotFoundHttpException;
use common\modules\books\models\Books;
use frontend\modules\user\models\{
    User, Group, Profile
};
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
                    'feedback-after-order' => ['post', 'get'],
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
        $phone = preg_replace('/\(|\)|\s|-|\+|[^\d]/', '', $model->phone);
        if ($model->load(Yii::$app->getRequest()->post()) && $model->validate() && !empty($phone) && strlen($phone)>=10) {
            $transaction = $model::getDb()->beginTransaction();
            try {
                $model->published = '1';
                
                $save = $model->save();

                $save ? $transaction->commit() : $transaction->rollBack();

                if ($save) {
                    $q=print_r($model,1);
                    $w=print_r(Yii::$app->getRequest()->post(),1);
                    $s=print_r($_SERVER,1);
                    $p=print_r($_REQUEST,1);
                    file_put_contents('/var/www/www-root/data/www/myarredo.ru/FormsFeedbackLog.txt', date('Y-m-d H:i:s').' form from  '.$s.' REQUEST '.$p.' model '.$q.' post '.$w."\n\r", FILE_APPEND);
                    if (strpos($model->email, 'daniil89217894501')) return $this->redirect(Yii::$app->request->referrer);
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
                        Yii::t('app', 'Отправлено')."<script>window.reachGoal='feedback';</script>"
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
     * @return string|Response
     */
    public function actionFeedbackAfterOrder($order_id = false)
    {
        if (empty($order_id) || empty(Yii::$app->getRequest()->get()['h'])){
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.').' 1');
        }

        $order = Order::findById($order_id);

        if (empty($order)){
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.').' 2');
        }

        $hash = md5($order->customer->id);

        if ($hash != Yii::$app->getRequest()->get()['h']){
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.').' 3');
        }

        $model = FormsFeedbackAfterOrder::findAll(['order_id'=>$order_id]);

        if ($model){
            throw new NotFoundHttpException(Yii::t('yii', 'Спасибо за отзыв!'));  
        }

        $this->layout = '@app/layouts/main_reviews';

        $this->title = Yii::t('app', 'Оцените сотрудничество с') . ' MYARREDO';

        /*$users = User::findBase()
                    ->andWhere([
                        'group_id' => Group::PARTNER,
                        User::tableName() . '.published' => '1',
                        Profile::tableName() . '.country_id' => $order->country_id,
                    ])
                    ->all();
       $arPartners = array();
        foreach ($users as $user) {
            if (!empty($user->profile) && !empty($user->profile->lang->name_company))
                $arPartners[$user->id] = $user->profile->lang->name_company.', '.$user->profile->city->lang->title;
        }
        asort($arPartners);*/

        $arPartners = array();
        foreach ($order->orderAnswers as $answer) {
           $user = $answer->user;
           if (!empty($user->profile) && !empty($user->profile->lang->name_company)){
                $arPartners[$user->id] = $user->profile->lang->name_company.(!empty($user->profile->city->lang->title) ? ', '.$user->profile->city->lang->title : ''); 
           } else {
                $arPartners[$user->id] = $user->username.(!empty($user->profile->city->lang->title) ? ', '.$user->profile->city->lang->title : ''); 
           }
        }
        asort($arPartners);

        /*$bookId = '88910536';
        if ($order->city) {
            $bookId = empty($order->city->country->bookId) ? '88910536' : $order->city->country->bookId;
        }
        //echo "<pre 111111111111111111111111>";var_dump($bookId);echo "</pre>";exit;
        $book = Books::getCampaign($bookId);
        $arFactories = array();
        foreach ($order->items as $item) {
            $arFactories[] = $item->product->factory_id;
        }
        //echo "<pre 111111111111111111111111>";var_dump($book);echo "</pre>";
        $arPartners = array();
        foreach ($book as $mail) {
            if (!empty($arFactories)) {
                $user = User::findBase()
                    ->andWhere([
                        'email' => $mail->email
                    ])
                    ->one();
                echo "<pre 111111111111111111111111>";var_dump($user->profile->factories);echo "</pre>";    
                if (empty($user) || empty($user->profile) || empty($user->profile->factories)) continue;
                
                if(!in_array($user->profile->country_id, [1,2,3])) {
                    $arUserFactories = array();
                    foreach($user->profile->factories as $factory){
                       $arUserFactories[] = $factory->id;
                    }
                    if (empty(array_intersect($arFactories,$arUserFactories))) continue;
                }
                $arPartners[$user->id] = $user->profile->lang->name_company;
            }
        }
exit;*/
        $model = new FormsFeedbackAfterOrder(['scenario' => 'frontend']);
        $model->user_id = $order->customer->id; 
        $model->order_id = $order->id; 
        if ($model->load(Yii::$app->getRequest()->post()) && $model->validate()) {
            $transaction = $model::getDb()->beginTransaction();
            try {
                $save = $model->save();

                $save ? $transaction->commit() : $transaction->rollBack();

                if ($save) {
                    return $this->redirect(Yii::$app->request->referrer);
                }
            } catch (Exception $e) {
                Yii::getLogger()->log($e->getMessage(), Logger::LEVEL_ERROR);
                $transaction->rollBack();

            }
        }

        return $this->render('feedback-after-order', [
            'model' => $model,
            'partners' => $arPartners
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
