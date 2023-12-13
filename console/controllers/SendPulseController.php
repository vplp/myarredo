<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\helpers\Console;
use frontend\modules\location\models\Country;
use frontend\modules\user\models\{
    User, Group, Profile
};
use frontend\modules\shop\models\Order;

/**
 * Class SendPulseController
 *
 * @package console\controllers
 */
class SendPulseController extends Controller
{
    /**
     * SendPulse: import emails
     */
    public function actionImportEmails()
    {
        $this->stdout("SendPulse: start actionImportEmails. \n", Console::FG_GREEN);

        /**
         * Import by country
         */   
        $modelCountry = Country::findBase()->all();

        foreach ($modelCountry as $country) {
            /**
             * Add new email to mailing lists
             */
            if ($country['bookId']) {
                $modelUser = User::find()
                ->joinWith(['countries'])
                ->andWhere([
                    'group_id' => Group::PARTNER,
                    User::tableName() . '.published' => '1',
                    'fv_user_rel_location_country.location_country_id' => $country['id']
                ])
                ->all();

                $bookId = $country['bookId'];
                $emails = [];

                $emails[] = [
                    'email' => strip_tags(Yii::$app->param->getByName('MAIL_SPECIAL_EMAIL')),
                    'variables' => [
                        'name' => 'SPECIAL_EMAIL',
                    ],
                ];

                foreach ($modelUser as $user) {
                    $emails[] = [
                        'email' => $user['email'],
                        'variables' => [
                            'name' => $user['profile']['fullName'],
                        ],
                    ];
                }
                Yii::$app->sendPulse->addEmails($bookId, $emails);
            }
        }

        /**
         * Import for sale italy 2289833
         */

        $modelUser = User::findBase()
            ->andWhere([User::tableName() . '.group_id' => Group::LOQISTICIAN])
            ->all();

        if ($modelUser != null) {
            $bookId = 2289833;
            $emails = [];

            foreach ($modelUser as $user) {
                $emails[] = [
                    'email' => $user['email'],
                    'variables' => [
                        'name' => $user['profile']['fullName'],
                    ],
                ];
            }

            Yii::$app->sendPulse->addEmails($bookId, $emails);
        }

        $this->stdout("SendPulse: end actionImportEmails. \n", Console::FG_GREEN);
    }

    /**
     * SendPulse: remove emails
     */
    public function actionRemoveEmails()
    {
        $this->stdout("SendPulse: start actionRemoveEmails. \n", Console::FG_GREEN);

        /**
         * Remove by country
         */

        $modelCountry = Country::findBase()->all();
              
        foreach ($modelCountry as $country) {
            if ($country['bookId']) {
                $bookId = $country['bookId'];
                $emails = [];

                $requestResult = Yii::$app->sendPulse->getEmailsFromBook($bookId);

                foreach ($requestResult as $item) {
                    $modelUser = User::find()
                        ->joinWith(['countries'])
                        ->andWhere([
                            'group_id' => Group::PARTNER,
                            User::tableName() . '.published' => '1',
                            'email' => $item->email,
                            //'fv_user_rel_location_country.location_country_id' => $country['id']
                        ]);

                    if (in_array($country['id'], [4,5,79,85])) {
                        $modelUser = $modelUser->andWhere(['IN','fv_user_rel_location_country.location_country_id', [4,5,79,85]]);
                    } else {
                        $modelUser = $modelUser->andWhere(['fv_user_rel_location_country.location_country_id'=>$country['id']]);
                    }

                    $modelUser = $modelUser->one();

                    if ($modelUser == null) {
                        $emails[] = $item->email;
                    }
                }

                if (!empty($emails)) {            
                    Yii::$app->sendPulse->removeEmails($bookId, $emails);
                }
            }
        }

        /**
         * Remove for sale italy 2289833
         */

        $bookId = 2289833;

        $requestResult = Yii::$app->sendPulse->getEmailsFromBook($bookId);

        foreach ($requestResult as $item) {
            $modelUser = User::findBase()
                ->andWhere([
                    'email' => $item->email,
                ])
                ->one();

            if ($modelUser == null) {
                $emails[] = $item->email;
            }
        }

        if (!empty($emails)) {
            Yii::$app->sendPulse->removeEmails($bookId, $emails);
        }

        $this->stdout("SendPulse: end actionRemoveEmails. \n", Console::FG_GREEN);
    }

    /**
     * SendPulse: send partner campaign
     */
    public function actionSendCampaign()
    {
        $this->stdout("SendPulse ".date("Y-m-d H:i:s").": start actionSendCampaign. \n", Console::FG_GREEN);

        /**
         * get order
         */
        $modelOrder = Order::findBase()
            ->andWhere([
                'create_campaign' => '0',
                'product_type' => 'product'
            ])
            ->orderBy(['created_at' => SORT_ASC])
            ->enabled()
            ->one();

        /** @var Order $modelOrder */

        if ($modelOrder !== null) {
            if ($modelOrder->city) {
                $bookId = empty($modelOrder->city->country->bookId) ? '88910536' : $modelOrder->city->country->bookId;
            } else {
                $bookId = '88910536';
            }

            $currentLanguage = Yii::$app->language;
            Yii::$app->language = $modelOrder->lang;

            $senderName = 'myarredo';
            $senderEmail = 'info@myarredo.ru';
            $subject = Yii::t('app', 'Новая заявка') . ' №' . $modelOrder['id'];
            $body = $bookId == '88910536' ? $this->renderPartial('letter_new_order_europe', ['order' => $modelOrder]) : $this->renderPartial('letter_new_order', ['order' => $modelOrder]);
            $name = Yii::t('app', 'Новая заявка') . ' №' . $modelOrder['id'];

            Yii::$app->language = $currentLanguage;

            /**
             * send partner campaign
             */
            $response = Yii::$app->sendPulse->createCampaign(
                $senderName,
                $senderEmail,
                $subject,
                $body,
                $bookId,
                $name,
                $modelOrder
            );

            $response = (array)$response;

            $this->stdout("Order id ".date("Y-m-d H:i:s").": " . $modelOrder['id'] . " \n", Console::FG_GREEN);

            if (!isset($response['is_error'])) {
                $modelOrder->setScenario('create_campaign');
                $modelOrder->create_campaign = '1';
                $modelOrder->save();

                /**
                 * send factory campaign
                 */
                $this->sendNewRequestForFactory($modelOrder);

                $this->stdout("Create campaign ".date("Y-m-d H:i:s").": " . $subject . " \n", Console::FG_GREEN);
            } else {
                $responseArray = array(
                    $senderName,
                    $senderEmail,
                    $subject,
                    $body,
                    $bookId,
                    $name
                );
                $this->stdout("Error in ".date("Y-m-d H:i:s")." " . $modelOrder['id'] . ': ' . $response['message'] . " \n".print_r($responseArray, 1) . " \n", Console::FG_GREEN);
            }
        }

        $this->stdout("SendPulse ".date("Y-m-d H:i:s").": end actionSendCampaign. \n", Console::FG_GREEN);
    }

    public function actionSendReviewInvoce()
    {
        $this->stdout("SendPulse ".date("Y-m-d H:i:s").": start actionSendReviewInvoce. \n", Console::FG_GREEN);

        /**
         * get order
         */
        $dateFrom = strtotime(date('Y-m-d 00:00:00', strtotime('-14 days')));
        $dateTo = strtotime(date('Y-m-d 23:59:59', strtotime('-14 days')));
        $modelOrders = Order::findBase()
            ->andWhere([
                'between', Order::tableName() . '.created_at', $dateFrom, $dateTo
            ])
            ->andWhere([
                Order::tableName() .'.country_id'=>2
            ])
            /*->andWhere([
                Order::tableName() .'.id'=>11520
            ])*/
            ->enabled()
            ->all();

        /** @var Order $modelOrder */

        if ($modelOrders !== null) {

            foreach ($modelOrders as $modelOrder) {

                $currentLanguage = Yii::$app->language;
                Yii::$app->language = $modelOrder->lang;

                $senderName = 'myarredo';
                $senderEmail = 'info@myarredo.ru';
                $subject = Yii::t('app', 'Оцените сотрудничество с') . ' MYARREDO';
                $body = $this->renderPartial('letter_review', ['order' => $modelOrder]);

                Yii::$app->language = $currentLanguage;

                /**
                 * send partner campaign
                 */
                $response = \Yii::$app->mailer
                                ->compose()
                                ->setFrom([$senderEmail => $senderName])
                                ->setTo($modelOrder->customer->email)
                                ->setBcc('dmd@liderpoiska.ru')
                                //->setTo('myarredo@myarredo.ru')
                                ->setSubject($subject)
                                ->setHtmlBody($body)
                                ->send();

                $response = (array)$response;

                if (isset($response['is_error'])) {
                    $responseArray = array(
                        $senderName,
                        $senderEmail,
                        $subject,
                        $body,
                    );
                    $this->stdout("Error in ".date("Y-m-d H:i:s")." " . $modelOrder['id'] . ': ' . $response['message'] . " \n".print_r($responseArray, 1) . " \n", Console::FG_GREEN);
                }
            }
        }

        $this->stdout("SendPulse ".date("Y-m-d H:i:s").": end actionSendReviewInvoce. \n", Console::FG_GREEN);
    }

    /**
     * SendPulse: send partner campaign sale-italy
     */
    public function actionSendCampaignSaleItaly()
    {
        $this->stdout("SendPulse: start actionSendCampaignSaleItaly. \n", Console::FG_GREEN);

        /**
         * get order
         */
        $modelOrder = Order::findBase()
            ->andWhere([
                'create_campaign' => '0',
                'product_type' => 'sale-italy'
            ])
            ->orderBy(['created_at' => SORT_ASC])
            ->enabled()
            ->one();

        if ($modelOrder !== null) {
            $currentLanguage = Yii::$app->language;
            Yii::$app->language = $modelOrder->lang;

            $bookId = 2289833;
            $senderName = 'myarredo';
            $senderEmail = 'info@myarredo.ru';
            $subject = Yii::t('app', 'Новая заявка') . ' №' . $modelOrder['id'];
            $body = $this->renderPartial('letter_new_order_sale_italy', ['order' => $modelOrder]);
            $name = Yii::t('app', 'Новая заявка') . ' №' . $modelOrder['id'];

            Yii::$app->language = $currentLanguage;

            /**
             * send partner campaign
             */
            $response = Yii::$app->sendPulse->createCampaign(
                $senderName,
                $senderEmail,
                $subject,
                $body,
                $bookId,
                $name
            );

            $response = (array)$response;

            var_dump($response);

            if (!isset($response['is_error'])) {
                $modelOrder->setScenario('create_campaign');
                $modelOrder->create_campaign = '1';
                $modelOrder->save();

                /**
                 * send factory campaign
                 */
                $this->sendNewRequestForFactory($modelOrder);

                $this->stdout("Create campaign: " . $subject . " \n", Console::FG_GREEN);
            }
        }

        $this->stdout("SendPulse: end actionSendCampaignSaleItaly. \n", Console::FG_GREEN);
    }

    /**
     * @param $modelOrder
     */
    private function sendNewRequestForFactory(Order $modelOrder)
    {
        $currentLanguage = Yii::$app->language;
        Yii::$app->language = $modelOrder->lang;

        foreach ($modelOrder->items as $item) {
            if ($item->product['factory_id'] && $item->product['factory'] && $item->product['factory']['email'] != '') {
                // use factory email
                $senderEmail = $item->product['factory']['email'];

                $this->stdout("Send to factory: " . $senderEmail . " \n", Console::FG_GREEN);

                $currentLanguage = Yii::$app->language;
                Yii::$app->language = 'it-IT';

                Yii::$app
                    ->mailer
                    ->compose(
                        'letter_new_order_for_factory_from_italy',
//                        !in_array($modelOrder->country_id, [1, 2, 3])
//                            ? 'letter_new_order_for_factory_from_italy'
//                            : 'letter_new_order_for_factory',
                        [
                            'order' => $modelOrder,
                            'item' => $item,
                            'isUser' => false
                        ]
                    )
                    ->setTo($senderEmail)
                    ->setSubject(Yii::t('app', 'Новый запрос на товар'))
                    ->send();

                Yii::$app->language = $currentLanguage;
            }

            if ($item->product['factory_id']) {
                // use user factory email
                /** @var $modelUser User */
                $modelUser = User::findBase()
                    ->andWhere([
                        'group_id' => Group::FACTORY,
                        Profile::tableName() . '.factory_id' => $item->product['factory_id']
                    ])
                    ->one();

                if ($modelUser !== null) {
                    $senderEmail = trim($modelUser['email']);

                    $this->stdout("Send to factory: " . $senderEmail . " \n", Console::FG_GREEN);

                    $currentLanguage = Yii::$app->language;
                    Yii::$app->language = 'it-IT';

                    Yii::$app
                        ->mailer
                        ->compose(
                            'letter_new_order_for_factory_from_italy',
//                            $modelUser->profile->factory->producing_country_id == 4
//                                ? 'letter_new_order_for_factory_from_italy'
//                                : 'letter_new_order_for_factory',
                            [
                                'order' => $modelOrder,
                                'item' => $item,
                                'isUser' => true
                            ]
                        )
                        ->setTo($senderEmail)
                        ->setSubject(Yii::t('app', 'Новый запрос на товар'))
                        ->send();

                    Yii::$app->language = $currentLanguage;
                }
            }
        }

        Yii::$app->language = $currentLanguage;
    }

    public function actionSendOrderAnswer()
    {
        $this->stdout("SendPulse: start actionSendOrderAnswer. \n", Console::FG_GREEN);

        // get order
        $models = Order::findBase()
            ->andWhere(['send_answer' => '0'])
            ->enabled()
            ->limit(10)
            ->all();

        foreach ($models as $modelOrder) {
            /** @var $modelOrder Order */

            $sendAnswer = false;

            $date1 = new \DateTime();
            $date2 = new \DateTime(date(DATE_ATOM, $modelOrder->created_at));

            $diff = $date2->diff($date1);
            $hours = $diff->h;
            $hours = $hours + ($diff->days * 24);

            if ($hours >= 3 && count($modelOrder->orderAnswers) >= 1) {
                $sendAnswer = true;
            } elseif (count($modelOrder->orderAnswers) >= 3) {
                $sendAnswer = true;
            }

            if ($sendAnswer) {
                $currentLanguage = Yii::$app->language;
                Yii::$app->language = $modelOrder->lang;

                // send user letter
                Yii::$app
                    ->mailer
                    ->compose(
                        'letter_send_order_answer',
                        [
                            'modelOrder' => $modelOrder
                        ]
                    )
                    ->setTo($modelOrder->customer['email'])
                    ->setSubject(Yii::t('app', 'Ответ за заказ') . ' № ' . $modelOrder['id'])
                    ->send();

                Yii::$app->language = $currentLanguage;

                $modelOrder->setScenario('send_answer');
                $modelOrder->send_answer = '1';
                $modelOrder->save();

                $this->stdout($modelOrder->id . "\n", Console::FG_GREEN);
            }
        }

        $this->stdout("SendPulse: end actionSendOrderAnswer. \n", Console::FG_GREEN);
    }

    public function actionSendTest1(){
        var_dump(Yii::$app->mailer);
        exit;
        var_dump(Yii::$app->sendPulse->sendSmtpBz('myarredo', 'info@myarredo.com', 'testAction', '<b>test action</b>', 99999));
    }
}
