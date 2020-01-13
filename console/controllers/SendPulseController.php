<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\helpers\Console;
//
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
        $this->stdout("SendPulse: start import emails. \n", Console::FG_GREEN);

        /**
         * Import by country
         */

        $modelCountry = Country::findBase()->all();

        foreach ($modelCountry as $country) {
            $modelUser = User::findBase()
                ->andWhere([
                    'group_id' => Group::PARTNER,
                    Profile::tableName() . '.country_id' => $country['id']
                ])
                ->all();

            /**
             * Add new email to mailing lists
             */
            if ($country['bookId']) {
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

        $this->stdout("SendPulse: end import emails. \n", Console::FG_GREEN);
    }

    /**
     * SendPulse: remove emails
     */
    public function actionRemoveEmails()
    {
        $this->stdout("SendPulse: start remove emails. \n", Console::FG_GREEN);

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
                    $modelUser = User::findBase()
                        ->andWhere([
                            'group_id' => Group::PARTNER,
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

        $this->stdout("SendPulse: end remove emails. \n", Console::FG_GREEN);
    }

    /**
     * SendPulse: send partner campaign
     */
    public function actionSendCampaign()
    {
        $this->stdout("SendPulse: start send test campaign. \n", Console::FG_GREEN);

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
            if ($modelOrder->city && in_array($modelOrder->lang, ['ru-RU'])) {
                $bookId = $modelOrder->city->country->bookId;
            } else if (in_array($modelOrder->lang, ['en-EN', 'it-IT'])) {
                $bookId = '88910536';
            }

            $currentLanguage = Yii::$app->language;
            Yii::$app->language = $modelOrder->lang;

            $senderName = 'myarredo';
            $senderEmail = 'info@myarredo.ru';
            $subject = Yii::t('app', 'Новая заявка') . ' №' . $modelOrder['id'];
            $body = $this->renderPartial('letter_new_order', ['order' => $modelOrder]);
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

        $this->stdout("SendPulse: end send test campaign. \n", Console::FG_GREEN);
    }

    /**
     * SendPulse: send partner campaign sale-italy
     */
    public function actionSendCampaignSaleItaly()
    {
        $this->stdout("SendPulse: start send test campaign. \n", Console::FG_GREEN);

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

        $this->stdout("SendPulse: end send test campaign. \n", Console::FG_GREEN);
    }

    /**
     * @param $modelOrder
     */
    private function sendNewRequestForFactory($modelOrder)
    {
        $currentLanguage = Yii::$app->language;
        Yii::$app->language = $modelOrder->lang;

        foreach ($modelOrder->items as $item) {
            if ($item->product['factory_id'] && $item->product['factory'] && $item->product['factory']['email'] != '') {
                // use factory email
                $senderEmail = $item->product['factory']['email'];

                $this->stdout("Send to factory: " . $senderEmail . " \n", Console::FG_GREEN);

                Yii::$app
                    ->mailer
                    ->compose(
                        in_array(substr($modelOrder->lang, 0, 2), ['en', 'it'])
                            ? 'letter_new_order_for_factory_from_italy'
                            : 'letter_new_order_for_factory',
                        [
                            'order' => $modelOrder,
                            'item' => $item,
                            'isUser' => false
                        ]
                    )
                    ->setTo($senderEmail)
                    ->setSubject(Yii::t('app', 'Новый запрос на товар'))
                    ->send();
            }

            if ($item->product['factory_id']) {
                // use user factory email
                $modelUser = User::findBase()
                    ->andWhere([
                        'group_id' => Group::FACTORY,
                        Profile::tableName() . '.factory_id' => $item->product['factory_id']
                    ])
                    ->one();

                if ($modelUser !== null) {
                    $senderEmail = trim($modelUser['email']);

                    $this->stdout("Send to factory: " . $senderEmail . " \n", Console::FG_GREEN);

                    Yii::$app
                        ->mailer
                        ->compose(
                            in_array(substr($modelOrder->lang, 0, 2), ['en', 'it'])
                                ? 'letter_new_order_for_factory_from_italy'
                                : 'letter_new_order_for_factory',
                            [
                                'order' => $modelOrder,
                                'item' => $item,
                                'isUser' => true
                            ]
                        )
                        ->setTo($senderEmail)
                        ->setSubject(Yii::t('app', 'Новый запрос на товар'))
                        ->send();
                }
            }
        }

        Yii::$app->language = $currentLanguage;
    }
}
