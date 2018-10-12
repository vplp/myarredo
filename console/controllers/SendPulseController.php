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
use common\modules\shop\models\Order;

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

        $this->stdout("SendPulse: end import emails. \n", Console::FG_GREEN);
    }

    /**
     * SendPulse: remove emails
     */
    public function actionRemoveEmails()
    {
        $this->stdout("SendPulse: start remove emails. \n", Console::FG_GREEN);

        $modelCountry = Country::findBase()->all();

        foreach ($modelCountry as $country) {
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

        $this->stdout("SendPulse: end remove emails. \n", Console::FG_GREEN);
    }

    /**
     * SendPulse: send partner campaign campaign
     */
    public function actionSendCampaign()
    {
        $this->stdout("SendPulse: start send test campaign. \n", Console::FG_GREEN);

        // get order

        $modelOrder = Order::findBase()
            ->andWhere(['create_campaign' => '0'])
            ->enabled()
            ->one();

        if ($modelOrder !== null) {
            $bookId = $modelOrder->city->country->bookId;
            $senderName = 'myarredo';
            $senderEmail = 'info@myarredo.ru';
            $subject = 'Новая заявка №' . $modelOrder['id'];
            $body = $this->renderPartial('letter_new_order_for_partner', ['order' => $modelOrder]);
            $name = 'Новая заявка №' . $modelOrder['id'];

            // send partner campaign

            $response = Yii::$app->sendPulse->createCampaign($senderName, $senderEmail, $subject, $body, $bookId, $name);

            $response = (array)$response;

            var_dump($response);

            if (!isset($response['is_error'])) {
                //$this->sendNewRequestForFactory($modelOrder);
                $modelOrder->setScenario('create_campaign');
                $modelOrder->create_campaign = '1';
                $modelOrder->save();
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
        foreach ($modelOrder->items as $item) {

            if (
                $item->product['factory_id'] &&
                $item->product['factory'] &&
                $item->product['factory']['email'] != ''
            ) {

                // use factory email

                $senderEmail = $item->product['factory']['email'];

                $this->stdout("Send to factory: " . $senderEmail . " \n", Console::FG_GREEN);

                Yii::$app
                    ->mailer
                    ->compose(
                        'letter_new_request_for_factory',
                        [
                            'order' => $modelOrder,
                            'item' => $item
                        ]
                    )
                    ->setTo($senderEmail)
                    ->setSubject('Новый запрос на товар')
                    ->send();

            } elseif ($item->product['factory_id']) {

                // use user factory email

                $modelUser = User::findBase()
                    ->andWhere([
                        'group_id' => Group::FACTORY,
                        Profile::tableName() . '.factory_id' => $item->product['factory_id']
                    ])
                    ->one();

                if ($modelUser !== null) {

                    $senderEmail = $modelUser['email'];

                    $this->stdout("Send to factory: " . $senderEmail . " \n", Console::FG_GREEN);

                    Yii::$app
                        ->mailer
                        ->compose(
                            'letter_new_request_for_factory',
                            [
                                'order' => $modelOrder,
                                'item' => $item
                            ]
                        )
                        ->setTo($senderEmail)
                        ->setSubject('Новый запрос на товар')
                        ->send();
                }
            }
        }
    }
}